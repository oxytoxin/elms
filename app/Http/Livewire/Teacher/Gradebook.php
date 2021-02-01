<?php

namespace App\Http\Livewire\Teacher;

use App\Exports\GradesExport;
use App\Models\Course;
use App\Models\GradingSystem;
use App\Models\Section;
use Livewire\Component;
use App\Models\TaskType;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Query\Builder;

class Gradebook extends Component
{

    public $courses;
    public $course;
    public $section_id;
    public $section;
    protected $tasks;
    protected $students;
    protected $task_types;
    public $course_id;
    public $readWeights = true;
    public GradingSystem $grading_system;
    public $editing = '';
    public $showEditDays = false;
    public $editValue = 0;
    public $activeStudent;
    public $colors = ['bg-red-200', 'bg-pink-200', 'bg-yellow-200', 'bg-orange-200', 'bg-indigo-200'];

    protected $listeners = ['confirmed', 'cancelled', 'refresh' => '$refresh'];

    protected $rules = [
        'grading_system.attendance_weight' => 'required|numeric|min:0',
        'grading_system.assignment_weight' => 'required|numeric|min:0',
        'grading_system.activity_weight' => 'required|numeric|min:0',
        'grading_system.quiz_weight' => 'required|numeric|min:0',
        'grading_system.exam_weight' => 'required|numeric|min:0',
        'editValue' => "numeric",
    ];

    protected $validationAttributes = [
        'editValue' => 'days present'
    ];

    public function render()
    {
        $weights = [
            'assignment' => $this->grading_system->assignment_weight,
            'activity' => $this->grading_system->activity_weight,
            'quiz' => $this->grading_system->quiz_weight,
            'exam' => $this->grading_system->exam_weight,
            'attendance' => $this->grading_system->attendance_weight,
        ];
        if (!$this->section_id) {
            $this->section_id = $this->course->sections->first()->id;
        }
        $this->task_types = TaskType::withTaskCount()->get();
        $this->section = Section::find($this->section_id);
        $this->grading_system = $this->section->grading_system;
        $this->tasks = $this->section->tasks()->with('task_type')->get()->groupBy('task_type_id')->sortKeys();
        $this->students = $this->section->students()->withName()->get()->sortBy('name');
        return view('livewire.teacher.gradebook', [
            'tasks' => $this->tasks,
            'students' => $this->students,
            'task_types' => $this->task_types,
            'weights' => $weights,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function editDays($editing, $student)
    {
        if ($editing == "Total Days") {
            $this->editValue = $student;
        } else {
            $this->activeStudent = $student;
            $student = $this->section->students->where('id', $student)->first();
            $this->editValue = $student->pivot->days_present;
        }
        $this->editing = $editing;
        $this->emitSelf('refresh');
        $this->showEditDays = true;
    }

    public function saveDays()
    {
        if ($this->editing == "Total Days") {

            $this->validate([
                'editValue' => "required|min:1|numeric",
            ]);
            $this->section->update([
                'total_days' => $this->editValue,
            ]);
            $this->section->students()->update([
                'days_present' => $this->editValue,
            ]);
        } else {
            $max = $this->section->total_days;
            $this->validate([
                'editValue' => "required|min:1|numeric|max:$max",
            ]);
            $this->section->students->where('id', $this->activeStudent)->first()->pivot->update([
                'days_present' => $this->editValue,
            ]);
        }
        $this->activeStudent = null;
        $this->alert('success', 'Days has been updated.');
        $this->showEditDays = false;
        $this->emitSelf('refresh');
    }

    public function mount()
    {
        $this->courses  = auth()->user()->teacher->courses;
        $this->course = auth()->user()->teacher->courses()->first();
        if (!$this->course) abort(404);
        $this->course_id = $this->course->id;
        $this->grading_system = Section::find($this->course->sections->first()->id)->grading_system;
    }


    public function saveWeights()
    {
        $this->validate();
        $sum = collect($this->grading_system)->filter(function ($value, $key) {
            return strpos($key, 'weight');
        })->sum();
        if ($sum !== 100) return $this->alert('error', 'The weights should add up to 100!');
        $this->grading_system->save();
        $this->readWeights = true;
        $this->alert('success', 'Grading system has been updated!');
    }

    public function cancelEdit()
    {
        $this->grading_system = Section::find($this->course->sections->first()->id)->grading_system;
        $this->readWeights = true;
    }

    public function export()
    {
        if ($this->section->ungraded) return $this->confirm('You have ungraded task submissions.', ['timer' => 0, 'toast' => false, 'position' => 'center', 'onConfirmed' => 'confirmed', 'showConfirmButton' => true, 'confirmButtonText' => 'Proceed', 'showCancelButton' => true]);
        $this->confirmed();
    }

    public function confirmed()
    {
        return Excel::download(new GradesExport, 'users.xlsx');
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