<?php

namespace App\Http\Livewire\Student;

use App\Models\Orientation;
use App\Models\Section;
use Livewire\Component;

class OrientationForm extends Component
{

    public Section $section;

    public function mount(Section $section)
    {
        $isStudentAllowed = (bool) $section->students()->where('student_id', auth()->user()->student->id)->first();
        if (!$isStudentAllowed) abort(403);
        $this->section = $section;
    }

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
