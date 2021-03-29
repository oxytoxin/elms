<?php

namespace App\Http\Livewire\Head;

use App\Models\Course;
use App\Models\Section;
use App\Models\Teacher;
use App\Notifications\GeneralNotification;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use function React\Promise\reduce;

class WorkloadUploader extends Component
{
    use WithFileUploads;

    public $teacher;
    protected $sections;
    public $workloadArray = [];
    public $workload;
    public $hasWorkload = false;
    public $fileId = 0;


    public function mount(Teacher $teacher)
    {
        $this->teacher = $teacher;
        $teacher->sections->count() ? $this->hasWorkload = true : '';
    }

    public function render()
    {
        $this->sections = $this->teacher->sections()->with('course')->get();
        return view('livewire.head.workload-uploader', [
            'sections' => $this->sections,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function uploadWorkload()
    {
        $workloadpath = $this->workload->storeAs('workloads', $this->workload->getClientOriginalName(), 'local');
        $handle = fopen(storage_path("app/$workloadpath"), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($this->workloadArray, $data);
        }
        array_splice($this->workloadArray, 0, 5);
        foreach ($this->workloadArray as  $key => $workload) {
            $this->workloadArray[$key] = array_values(array_filter($workload, fn ($value) => !is_null($value) && $value !== ''));
        }
        $this->workloadArray = array_filter($this->workloadArray, fn ($value) => !is_null($value) && $value !== '' && $value !== []);
        array_splice($this->workloadArray, -1, 1);
        // dd($this->workloadArray);
        foreach ($this->workloadArray as $key => $wload) {
            $course = Course::where('code', $wload[1])->first();
            if (!$course) {
                $this->alert('error', 'Error: Some courses were not found in the database. Course code: ' . $wload[1], [
                    'toast' => false,
                    'position' => 'center'
                ]);
                $this->workloadArray = [];
                // $this->fileId += 1;
                return session()->flash('error', 'Error: Some courses were not found in the database.');
            }
        }
        DB::transaction(function () {
            $workloadChanged = false;
            foreach ($this->workloadArray as $key => $load) {
                if (isset($load[1])) {
                    $code = trim($load[1]);
                    $code = str_replace([' ', '-'], '', $code);
                    $course = Course::where('code', $code)->first();
                    if ($course && !$course->sections->contains('code', $load[2])) {
                        if (!$course->teachers->contains($this->teacher))
                            $course->teachers()->attach($this->teacher);
                        $s = Section::create(['code' => $load[2], 'teacher_id' => $this->teacher->id, 'course_id' => $course->id, 'room' => $load[5] ?? '', 'schedule' => $load[4] ?? '']);
                        $s->grading_system()->create();
                        $chatroom = $s->chatroom()->create([
                            'name' => $s->course->name . ' - (' . $s->code . ')',
                            'isGroup' => true,
                        ]);
                        $chatroom->messages()->create([
                            'sender_id' => null,
                            'message' => $this->teacher->user->name . ' has joined the group.'
                        ]);
                        $chatroom->members()->attach($this->teacher->user_id);
                        $workloadChanged = true;
                    }
                }
            }
            if ($workloadChanged) $this->teacher->user->notify(new GeneralNotification('Your workload has been updated.', route('teacher.faculty_workload')));
        });
        $this->workloadArray = [];
        $this->fileId += 1;
        $this->hasWorkload = true;
        return session()->flash('message', 'Workload was successfully added to faculty member.');
    }
}