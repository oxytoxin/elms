<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TeacherTasklist extends Component
{
    use WithPagination;
    public $submissions;
    public $task;
    public $submissionFilter;
    protected $students;
    public $search = "";
    public $showDeadlineExtension = false;

    protected $listeners = [
        'confirmDelete',
        'cancelDelete'
    ];

    public function confirmDelete()
    {
        $this->task->delete();
        return redirect()->route('teacher.tasks', ['task_type' => $this->task->task_type_id]);
    }

    public function cancelDelete()
    {
        return;
    }

    public function mount(Task $task)
    {
        $isAllowed = $task->section->teacher_id == auth()->user()->teacher->id;
        if (!$isAllowed) abort(403);
        $this->task = $task;

        if (session("task" . $task->id . "filter")) $this->submissionFilter = session("task" . $task->id . "filter");
        else $this->submissionFilter = "all";
    }

    public function render()
    {
        if ($this->search) $this->resetPage();
        $query = $this->task->students();
        if ($this->search) $query = $query->whereHas('user', function ($q) {
            $q->where('name', 'like', "%$this->search%");
        });
        switch ($this->submissionFilter) {
            case 'graded':
                $query = $query->where('isGraded', true);
                break;
            case 'ungraded':
                $this->students = $query->where('isGraded', false);
                break;
            default:
                break;
        }
        $this->students = $query->withName()->with(['department', 'user'])->orderBy('name')->paginate(5);
        return view('livewire.teacher-tasklist', [
            'students' => $this->students,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function deleteTask()
    {
        $this->confirm('Confirm deletion of this task along with all student submissions?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Cancel',
            'onConfirmed' => 'confirmDelete',
            'onCancelled' => 'cancelDelete'
        ]);
    }

    public function updatingSubmissionFilter($value)
    {
        session(["task" . $this->task->id . "filter" => $value]);
        $this->submissionFilter = session("task" . $this->task->id . "filter");
        $this->resetPage();
    }
}
