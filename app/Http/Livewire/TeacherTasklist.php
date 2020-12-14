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
    public $showDeadlineExtension = false;
    public function render()
    {
        return view('livewire.teacher-tasklist', [
            'students' => $this->task->students()->orderBy('date_submitted', 'desc')->paginate(10)
        ])
            ->extends('layouts.master')
            ->section('content');
    }
    public function mount(Task $task)
    {
        $this->task = $task;
    }
}
