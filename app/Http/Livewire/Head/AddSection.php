<?php

namespace App\Http\Livewire\Head;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use App\Models\Department;
use App\Notifications\GeneralNotification;
use DB;

class AddSection extends Component
{

    protected $courses;
    protected $teachers;
    public $section_code = '';
    public $schedule = '';
    public $room = '';
    public $course_select = "null";
    public $faculty_select = "null";


    protected $messages = [
        'course_select.numeric' => "Please select what course to add the section in.",
        'faculty_select.numeric' => "Please select a faculty member to assign the section in."
    ];


    public function render()
    {
        $this->courses = auth()->user()->program_head->courses;
        $department = Department::find(auth()->user()->program_head->department_id);
        $this->teachers = $department ? $department->teachers : collect();
        return view('livewire.head.add-section', [
            'teachers' => $this->teachers,
            'courses' => $this->courses
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function addSection()
    {
        $this->validate([
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
            $chatroom = $section->chatroom->create([
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
            Course::find($this->course_select)->teachers()->attach($this->faculty_select);
        });
        session()->flash('message', 'Section successfully added.');
        $this->section_code = '';
        $this->schedule = '';
        $this->room = '';
        $this->course_select = "null";
        $this->faculty_select = "null";
    }
}