<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;

class TaskTaker extends Component
{
    public $task;
    public $answers = [];
    public $task_content;

    public function render()
    {
        return view('livewire.task-taker')
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->task_content = json_decode($this->task->content, true);
    }
}
