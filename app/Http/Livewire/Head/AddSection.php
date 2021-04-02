<?php

namespace App\Http\Livewire\Head;

use DB;
use App\Models\Course;
use App\Models\Section;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Department;
use App\Notifications\GeneralNotification;

class AddSection extends Component
{

    protected $courses;
    public $department_id = "";
    public $course_query = "";
    protected $teachers;
    public $section_code = '';
    public $schedule = '';
    public $room = '';
    public $course_select = "";
    public $faculty_select = "";
    public $showQuery = false;


    protected $messages = [
        'course_select.numeric' => "Please select what course to add the section in.",
        'faculty_select.numeric' => "Please select a faculty member to assign the section in."
    ];


    public function render()
    {
        $this->courses = Course::query();
        if ($this->course_query) {
            $this->showQuery = true;
            $this->courses = $this->courses->where('name', 'like', "%{$this->course_query}%")->orWhere('code', 'like', "%{$this->course_query}%");
        } else $this->showQuery = false;
        $this->courses = $this->courses->get()->take(20);
        $department = Department::find($this->department_id);
        $this->teachers = $department ? $department->teachers : collect();
        $c = Course::find($this->course_select);
        if ($this->courses->unique('name')->count() == 1 && $this->courses->first()->name == $this->course_query) $this->showQuery = false;
        return view('livewire.head.add-section', [
            'teachers' => $this->teachers,
            'courses' => $this->courses
        ])
            ->extends('layouts.master')
            ->section('content');
    }


    public function setCourse($course, $name)
    {
        $this->course_select = $course;
        $this->course_query = $name;
    }

    public function addSection()
    {
        $this->validate([
            'department_id' => 'required',
            'section_code' => 'required',
            'schedule' => 'required',
            'room' => 'required',
            'course_select' => 'required|numeric',
            'faculty_select' => 'required|numeric'
        ]);

        DB::transaction(function () {
            $section = Section::create([
                'code' => $this->section_code,
                'teacher_id' => $this->faculty_select,
                'course_id' => $this->course_select,
                'schedule' => $this->schedule,
                'room' => $this->room
            ]);
            $section->grading_system()->create();
            $chatroom = $section->chatroom()->create([
                'name' => $section->course->name . ' - (' . $section->code . ')',
                'isGroup' => true,
            ]);
            $t = Teacher::find($this->faculty_select);
            $chatroom->members()->attach($t->user_id);
            $chatroom->messages()->create([
                'sender_id' => null,
                'message' => $t->user->name . ' has joined the group.'
            ]);
            $section->teacher->user->notify(new GeneralNotification('Your workload has been updated.', route('teacher.faculty_workload')));
            $c =  Course::find($this->course_select);
            if (!$c->teachers()->where('teacher_id', $this->faculty_select)->first())
                $c->teachers()->attach($this->faculty_select);
        });
        session()->flash('message', 'Section successfully added.');
        $this->section_code = '';
        $this->schedule = '';
        $this->room = '';
        $this->course_select = "null";
        $this->faculty_select = "null";
    }
}