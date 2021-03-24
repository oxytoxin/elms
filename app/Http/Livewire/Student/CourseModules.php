<?php

namespace App\Http\Livewire\Student;

use App\Models\Orientation;
use App\Models\Section;
use Livewire\Component;

class CourseModules extends Component
{
    public $section;
    public function mount(Section $section)
    {

        $this->section = $section;
        $orientation = Orientation::where('user_id', auth()->id())->where('section_id', $section->id)->first();
        if (!$orientation) return redirect()->route('student.orientation', ['section' => $section]);
    }

    public function render()
    {
        return view('livewire.student.course-modules')
            ->extends('layouts.master')
            ->section('content');
    }
}