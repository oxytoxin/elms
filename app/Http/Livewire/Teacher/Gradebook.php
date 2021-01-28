<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use App\Models\Section;
use Livewire\Component;
use App\Models\TaskType;
use Illuminate\Database\Query\Builder;

class Gradebook extends Component
{

    public $courses;
    public $course;
    public $section_id;
    public $sections;
    protected $tasks;
    public $students;
    public $task_types;
    public $course_id;

    public function render()
    {
        if (!$this->section_id) {
            $this->section_id = $this->course->sections->first()->id;
        }
        $this->tasks = Section::find($this->section_id)->tasks->filter(function ($t) {
            return $t->course->id == $this->course_id;
        })->groupBy('task_type_id');
        $this->students = $this->course->studentsBySection($this->section_id)->where('teacher_id', auth()->user()->teacher->id)->get()->sortBy('user.name');
        return view('livewire.teacher.gradebook', [
            'tasks' => $this->tasks,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount()
    {
        $this->courses  = auth()->user()->teacher->courses;
        $this->task_types = TaskType::all();
        $this->course = auth()->user()->teacher->courses()->first();
        if (!$this->course) abort(404);
        $this->course_id = $this->course->id;
    }
    public function updateCourse()
    {
        $this->course = Course::find($this->course_id);
        $this->section_id = $this->course->sections->first()->id;
    }

    public function updateSection()
    {
        $this->students = $this->course->studentsBySection($this->section_id)->where('teacher_id', auth()->user()->teacher->id)->get()->sortBy('user.name');
    }
}
