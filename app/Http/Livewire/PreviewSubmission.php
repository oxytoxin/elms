<?php

namespace App\Http\Livewire;

use App\Models\StudentTask;
use Livewire\Component;

class PreviewSubmission extends Component
{
    public $submission;
    public $assessment;
    public $task;
    public $questions;
    public $answers;
    public $matchingTypeOptions;

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
        if ($this->task->matchingtype_options) $this->matchingTypeOptions = json_decode($this->task->matchingtype_options, true);
        $this->questions = json_decode($this->task->content, true);
        $this->answers = json_decode($this->submission->answers, true);
        $this->assessment = json_decode($this->submission->assessment, true);
    }
}
