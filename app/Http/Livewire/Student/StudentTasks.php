<?php

namespace App\Http\Livewire\Student;

use Livewire\Component;
use App\Models\TaskType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;

class StudentTasks extends Component
{
    use WithPagination;
    public $task_type;
    protected $tasks;
    public $display_grid = true;
    public $filter = "all";

    public function render()
    {
        switch ($this->filter) {
            case 'all':
                $this->tasks = auth()->user()->student->tasksByType($this->task_type->id);
                break;
            case 'hasSubmission':
                $this->tasks = auth()->user()->student->hasSubmission($this->task_type->id);
                break;
            case 'hasNoSubmission':
                $this->tasks = auth()->user()->student->hasNoSubmission($this->task_type->id);
                break;
            case 'pastDeadline':
                $this->tasks = auth()->user()->student->pastDeadline($this->task_type->id);
                break;
        }
        $page = Paginator::resolveCurrentPage() ?: 1;
        $perPage = 10;
        $this->tasks = new LengthAwarePaginator(
        $this->tasks->forPage($page, $perPage), $this->tasks->count(), $perPage, $page, ['path' => Paginator::resolveCurrentPath()]
        );
        return view('livewire.student.student-tasks',[
            'tasks' => $this->tasks,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount($task_type)
    {
        $this->tasks = auth()->user()->student->tasksByType($task_type);
        $this->task_type = TaskType::find($task_type);
    }
    public function displayGrid()
    {
        $this->display_grid = true;
        switch ($this->filter) {
            case 'all':
                $this->tasks = auth()->user()->student->tasksByType($this->task_type->id);
                break;
            case 'hasSubmission':
                $this->tasks = auth()->user()->student->hasSubmission($this->task_type->id);
                break;
            case 'hasNoSubmission':
                $this->tasks = auth()->user()->student->hasNoSubmission($this->task_type->id);
                break;
            case 'pastDeadline':
                $this->tasks = auth()->user()->student->pastDeadline($this->task_type->id);
                break;
        }
    }
    public function displayList()
    {
        $this->display_grid = false;
        switch ($this->filter) {
            case 'all':
                $this->tasks = auth()->user()->student->tasksByType($this->task_type->id);
                break;
            case 'hasSubmission':
                $this->tasks = auth()->user()->student->hasSubmission($this->task_type->id);
                break;
            case 'hasNoSubmission':
                $this->tasks = auth()->user()->student->hasNoSubmission($this->task_type->id);
                break;
            case 'pastDeadline':
                $this->tasks = auth()->user()->student->pastDeadline($this->task_type->id);
                break;
        }
    }
    public function noFilter()
    {
        $this->resetPage();
        $this->filter = "all";
        $this->tasks = auth()->user()->student->tasksByType($this->task_type->id);
    }
    public function filterWithSubmission()
    {
        $this->resetPage();
        $this->filter = "hasSubmission";
        $this->tasks = auth()->user()->student->hasSubmission($this->task_type->id);
    }
    public function filterWithNoSubmission()
    {
        $this->resetPage();
        $this->filter = "hasNoSubmission";
        $this->tasks = auth()->user()->student->hasNoSubmission($this->task_type->id);
    }
    public function filterPastDeadline()
    {
        $this->resetPage();
        $this->filter = "pastDeadline";
        $this->tasks = auth()->user()->student->pastDeadline($this->task_type->id);
    }
}
