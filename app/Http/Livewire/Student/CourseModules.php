<?php

namespace App\Http\Livewire\Student;

use App\Models\Orientation;
use App\Models\Section;
use Livewire\Component;

class CourseModules extends Component
{
    public $section;
    public $orientation;

    protected $listeners = ['orientation'];

    public function orientation()
    {
        if ($this->orientation)
            $this->alert('error', 'Please read your course syllabus and accept the orientation form to access other modules.', ['toast' => false, 'position' => 'center']);
    }

    public function mount(Section $section)
    {
        $this->orientation = (bool)request('orient');
        $this->section = $section;
        // $orientation = Orientation::where('user_id', auth()->id())->where('section_id', $section->id)->first();
        // if (!$orientation) return redirect()->route('student.orientation', ['section' => $section]);
    }

    public function render()
    {
        return view('livewire.student.course-modules')
            ->extends('layouts.master')
            ->section('content');
    }
}