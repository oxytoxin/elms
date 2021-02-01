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
        $workload = $this->workload->storeAs('workloads', $this->workload->getClientOriginalName(), 'local');
        $handle = fopen(storage_path("app/$workload"), "r");
        while (($data = fgetcsv($handle)) !== FALSE) {
            array_push($this->workloadArray, $data);
        }
        array_splice($this->workloadArray, 0, 5);
        DB::transaction(function () {
            $workloadChanged = false;
            foreach ($this->workloadArray as $key => $load) {
                if (isset($load[1])) {
                    $code = $load[1];
                    $code = str_replace([' ', '-'], '', $code);
                    $course = Course::where('code', $code)->first();
                    if ($course && !$course->sections->contains('code', $load[3])) {
                        if (!$course->teachers->contains($this->teacher))
                            $course->teachers()->attach($this->teacher);
                        $s = Section::create(['code' => $load[3], 'teacher_id' => $this->teacher->id, 'course_id' => $course->id, 'room' => $load[9], 'schedule' => $load[7]]);
                        $s->grading_system()->create();
                        $workloadChanged = true;
                    }
                }
            }
            if ($workloadChanged) $this->teacher->user->notify(new GeneralNotification('Your workload has been updated.', route('teacher.faculty_workload')));
        });
        $this->workloadArray = [];
        $this->fileId += 1;
        $this->hasWorkload = true;
        session()->flash('message', 'Workload was successfully added to faculty member.');
    }
}