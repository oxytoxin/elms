<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Task;
use Livewire\Component;

class TaskPreview extends Component
{

    public $task;
    public $rubric;
    public $task_content;
    public $matchingTypeOptions;

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->rubric = json_decode($task->essay_rubric, true);
        $this->task_content = json_decode($this->task->content, true);
        if ($task->matchingtype_options) $this->matchingTypeOptions = json_decode($task->matchingtype_options, true);
    }


    public function render()
    {
        return view('livewire.teacher.task-preview')
            ->extends('layouts.master')
            ->section('content');
    }

    public function getRating($key)
    {
        return $rating = round(100 * (1 / ($key + 1)), 2);
    }
}
