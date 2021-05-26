<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Draft;
use Livewire\Component;

class TaskDrafts extends Component
{

    public function render()
    {
        return view('livewire.teacher.task-drafts', [
            'drafts' => auth()->user()->teacher->drafts,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function deleteDraft(Draft $draft)
    {
        $draft->delete();
        $this->alert('success', "Draft was deleted successfully.", [
            'toast' => false,
            'position' => 'center',
        ]);
    }
}
