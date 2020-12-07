<?php

namespace App\Http\Livewire\Head;

use App\Models\Course;
use App\Models\Department;
use App\Models\Section;
use Livewire\Component;

class AddSection extends Component
{

    public $courses;
    public $teachers;
    public $section_code = '';
    public $schedule = '';
    public $room = '';
    public $course_select = "null";
    public $faculty_select = "null";


    protected $messages = [
        'course_select.numeric' => "Please select what course to add the section in.",
        'faculty_select.numeric' => "Please select a faculty member to assign the section in."
    ];

    function mount()
    {
        $this->courses = Course::byDepartment(auth()->user()->program_head->department_id)->get();
        $this->teachers = Department::find(auth()->user()->program_head->department_id)->teachers;
    }

    public function render()
    {
        return view('livewire.head.add-section')
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

        Section::create([
            'code' => $this->section_code,
            'teacher_id' => $this->faculty_select,
            'course_id' => $this->course_select,
            'schedule' => $this->schedule,
            'room' => $this->room
        ]);
        Course::find($this->course_select)->teachers()->attach($this->faculty_select);
        session()->flash('message', 'Section successfully added.');
        $this->section_code = '';
        $this->schedule = '';
        $this->room = '';
        $this->course_select = "null";
        $this->faculty_select = "null";
    }
}
