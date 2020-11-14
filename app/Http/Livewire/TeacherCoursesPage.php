<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Student;
use Livewire\Component;
use App\Models\Resource;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class TeacherCoursesPage extends Component
{
    use WithFileUploads;

    public $tab = 'student';
    public $email = '';
    public $course;
    public $module_id;
    public $moduleSelected;
    public $title;
    public $description;
    public $resources = [];
    public $fileId = 0;

    public function render()
    {
        return view('livewire.teacher-courses-page');
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
        $student = User::has('student')->where('email', $this->email)->firstOrFail()->student;
        if (!$this->course->students->contains($student)) {
            $this->course->students()->attach($student->id, ['teacher_id' => auth()->user()->teacher->id]);
            auth()->user()->teacher->students()->attach($student->id, ['course_id' => $this->course->id]);
            $this->course =  Course::find($this->course->id);
            $this->email = "";
            session()->flash('message', 'Student succesfully enrolled.');
        } else
            session()->flash('message', 'Student already enrolled.');
    }
    public function removeStudent(Student $student)
    {
        $this->course->students()->detach($student);
        $this->course =  Course::find($this->course->id);
        session()->flash('message', 'Faculty member succesfully removed.');
    }
    public function addResources()
    {
        $this->validate([
            'module_id' => ['required', 'not_in:0'],
            'title' => 'required|string',
            'description' => 'required|string',
            'resources.*' => 'required|file'
        ]);

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

        $this->fileId++;
        $this->title = "";
        $this->description = "";
        $this->module_id = null;
        $this->moduleSelected = null;
        $this->resources = [];
        $this->course = Course::find($this->course->id);
        session()->flash('message', 'Resources have been added.');
    }
    public function removeResource(Resource $resource)
    {
        foreach ($resource->files as $f) {
            Storage::cloud()->delete($f->google_id);
        }
        $resource->delete();
        $this->course = Course::find($this->course->id);
        session()->flash('message', 'Module resources have been updated.');
    }
}
