<?php

namespace App\Http\Livewire\Teacher;

use Livewire\Component;

class FacultyWorkload extends Component
{
    protected $sections;


    public function render()
    {
        $this->sections = auth()->user()->teacher->sections()->with('course')->get();
        return view('livewire.teacher.faculty-workload', [
            'sections' => $this->sections,
        ])
            ->extends('layouts.master')
            ->section('content');
    }
}
