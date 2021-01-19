<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use Livewire\Component;
use App\Models\Resource;
use App\Models\Section;
use App\Notifications\GeneralNotification;
use DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class TeacherCoursesPage extends Component
{
    use WithFileUploads;

    public $tab = 'student';
    public $email = '';
    public $section;
    public $module_id;
    public $moduleSelected;
    public $title;
    public $description;
    public $resources = [];
    public $fileId = 0;
    public $showInviteCode = false;
    public $inviteCode = '';

    public function render()
    {
        return view('livewire.teacher-courses-page')
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount(Section $section)
    {
        $this->section = $section;
        // $this->inviteCode = Crypt::encrypt(['course_id' => $section->course_id, 'section_id' => $section->id, 'teacher_id' => auth()->user()->teacher->id]);
        $this->inviteCode = base64_encode(json_encode(['course_id' => $section->course_id, 'section_id' => $section->id, 'teacher_id' => auth()->user()->teacher->id]));
    }

    public function updateModule()
    {
        $this->moduleSelected = Module::find($this->module_id);
    }

    public function enrolStudent()
    {
        $this->validate([
            'email' => 'required|email',
        ]);
        $u = User::has('student')->where('email', $this->email)->first();
        if($u) $student = $u->student;
        else return session()->flash('error', 'Student not found.');
        if (!$this->section->students->contains($student)) {
            auth()->user()->teacher->students()->attach($student->id, ['course_id' => $this->section->course->id, 'section_id' => $this->section->id]);
            $this->section =  $this->section;
            $this->email = "";
            $student->user->notify(new GeneralNotification("You have been enrolled to " . $this->section->course->code . " (" . $this->section->code . ").", route('student.home')));
            session()->flash('message', 'Student succesfully enrolled.');
        } else
            session()->flash('message', 'Student already enrolled.');
    }
    public function removeStudent(Student $student)
    {
        $this->section->students()->detach($student);
        $this->section =  $this->section;
        session()->flash('message', 'Student succesfully unenrolled.');
    }
    public function addResources()
    {
        $this->validate([
            'module_id' => ['required', 'not_in:0'],
            'title' => 'required|string',
            'description' => 'required|string',
            'resources.*' => 'required|file'
        ]);

        DB::transaction(function () {
            $res = Resource::create([
                'teacher_id' => auth()->user()->teacher->id,
                'module_id' => $this->module_id,
                'title' => $this->title,
                'description' => $this->description
            ]);
            foreach ($this->resources as $resource) {
                // $url = $resource->store("", Carbon::now()->format('Ymdhis') . $resource->getClientOriginalName(), 'google');
                $url = $resource->store("", 'google');
                $match = gdriver($url);
                $res->files()->create([
                    'google_id' => $match['id'],
                    'name' => $resource->getClientOriginalName(),
                    'url' => $url
                ]);
            }
        });

        $this->fileId++;
        $this->title = "";
        $this->description = "";
        $this->module_id = null;
        $this->moduleSelected = null;
        $this->resources = [];
        $this->section = $this->section;
        session()->flash('message', 'Resources have been added.');
    }
    public function removeResource(Resource $resource)
    {
        foreach ($resource->files as $f) {
            Storage::cloud()->delete($f->google_id);
        }
        $resource->delete();
        $this->section = $this->section;
        session()->flash('message', 'Module resources have been updated.');
    }
}
