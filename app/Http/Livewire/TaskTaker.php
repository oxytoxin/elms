<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Carbon\Carbon;
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

    public function submitAnswers()
    {
        $this->task->students()->attach(auth()->user()->id, ['date_submitted' => Carbon::now()->format('Y-m-d H:i:s'), 'answers' => json_encode($this->answers)]);
        return redirect()->route('student.tasks', ['task_type' => $this->task->task_type_id]);
    }
}
