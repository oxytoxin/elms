<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use App\Models\TaskType;
use Livewire\Component;

class Gradebook extends Component
{

    public $courses;
    public $course;
    public $tasks;
    public $students;
    public $task_types;
    public $course_id;

    public function render()
    {
        return view('livewire.teacher.gradebook')
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount()
    {
        $this->courses  = auth()->user()->teacher->courses;
        $this->task_types = TaskType::all();
        $this->course = auth()->user()->teacher->courses()->first();
        $this->tasks = $this->course->modules->flatMap(function ($m) {
            return $m->tasks;
        })->groupBy('task_type_id')->sortKeys();
        $this->students = $this->course->students()->where('teacher_id', auth()->user()->teacher->id)->get()->sortBy('user.name');
    }
    public function updateCourse()
    {
        $this->course = Course::find($this->course_id);
        $this->tasks = $this->course->modules->flatMap(function ($m) {
            return $m->tasks;
        })->groupBy('task_type_id')->sortKeys();
        $this->students = $this->course->students()->where('teacher_id', auth()->user()->teacher->id)->get()->sortBy('user.name');
    }

    private function resetProps()
    {
    }
}
