<?php

namespace App\Http\Livewire;

use DB;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use App\Models\Resource;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\GeneralNotification;

class TeacherCoursesPage extends Component
{
    use WithFileUploads;
    protected $listeners = ['copyAlert'];

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
    public $showQuery = false;
    protected $students = [];

    public $messages = [
        'resources.filled' => 'A file is required for module resources.',
    ];

    public function render()
    {
        if ($this->email) {
            $this->showQuery = true;
            $this->students = User::where('name', 'like', "%$this->email%")->whereHas('roles', function (Builder $query) {
                $query->where('role_id', 2);
            })->orWhere('email', 'like', "%$this->email%")->whereHas('roles', function (Builder $query) {
                $query->where('role_id', 2);
            })->get();
        } else {
            $this->showQuery = false;
            $this->students = [];
        }
        return view('livewire.teacher-courses-page', [
            'students' => $this->students,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function createMeeting()
    {
        if ($this->section->videoroom) return;
        $this->section->videoroom()->create([
            'code' => base64_encode($this->section->id . $this->section->code . Str::random(40)),
        ]);
        $this->section = Section::find($this->section->id);
    }

    public function joinMeeting()
    {
        return redirect()->route('teacher.meeting', ['room' => $this->section->videoroom->code, 'section_id' => $this->section->id]);
    }

    public function mount(Section $section)
    {
        $this->section = $section;
        // $this->inviteCode = Crypt::encrypt(['course_id' => $section->course_id, 'section_id' => $section->id, 'teacher_id' => auth()->user()->teacher->id]);
        $this->inviteCode = base64_encode(json_encode(['course_id' => $section->course_id, 'section_id' => $section->id, 'teacher_id' => auth()->user()->teacher->id]));
    }

    public function setEmail($stud)
    {
        $this->email = $stud['email'];
        $this->enrolStudent();
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
        if ($u) $student = $u->student;
        else return $this->alert('warning', 'Student not found.', ['toast' => false, 'position' => 'center']);
        if (!$this->section->students->contains($student)) {
            auth()->user()->teacher->students()->attach($student->id, ['course_id' => $this->section->course->id, 'section_id' => $this->section->id]);
            $this->section =  $this->section;
            $this->email = "";
            $student->user->notify(new GeneralNotification("You have been enrolled to " . str_replace(' ', '', $this->section->course->code) . "(" . str_replace(' ', '', $this->section->code) . ").", route('student.home')));
            $this->section->chatroom->members()->attach($u->id);
            $this->alert('success', 'Student successfully enrolled.', ['toast' => false, 'position' => 'center']);
        } else
            $this->alert('warning', 'Student is already enrolled.', ['toast' => false, 'position' => 'center']);
    }
    public function removeStudent(Student $student)
    {
        $this->section->chatroom->members()->detach($student->user_id);
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
            'resources' => 'filled'
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
                $url = $resource->store("", 'resources');
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
        // $this->module_id = null;
        $this->updateModule();
        $this->resources = [];
        $this->section = $this->section;
        $this->alert('success', 'Resources have been added.');
        $this->dispatchBrowserEvent('remove-files');
    }
    public function removeResource(Resource $resource)
    {
        foreach ($resource->files as $f) {
            Storage::cloud()->delete($f->google_id);
        }
        $resource->delete();
        $this->section = $this->section;
        $this->alert('success', 'Module resources have been removed.', ['toast' => false, 'position' => 'center']);
    }

    public function copyAlert()
    {
        $this->alert('success', 'Enrolment code copied!');
    }
}
