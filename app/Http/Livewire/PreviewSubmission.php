<?php

namespace App\Http\Livewire;

use App\Models\StudentTask;
use Livewire\Component;

class PreviewSubmission extends Component
{
    public $submission;
    public $task;
    public $questions;
    public $answers;

    public function render()
    {
        return view('livewire.preview-submission')
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount(StudentTask $submission)
    {
        $this->submission = $submission;
        $this->task = $submission->task;
        $this->questions = json_decode($this->task->content, true);
        $this->answers = json_decode($this->submission->answers, true);
    }
}
