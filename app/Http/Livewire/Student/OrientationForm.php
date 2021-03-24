<?php

namespace App\Http\Livewire\Student;

use App\Models\Orientation;
use App\Models\Section;
use Livewire\Component;

class OrientationForm extends Component
{

    public Section $section;

    public function render()
    {
        return view('livewire.student.orientation-form')
            ->extends('layouts.master')
            ->section('content');
    }

    public function acceptOrientation()
    {
        Orientation::create([
            'user_id' => auth()->id(),
            'section_id' => $this->section->id,
        ]);
        return redirect()->route('student.course_modules', ['section' => $this->section->id]);
    }
}