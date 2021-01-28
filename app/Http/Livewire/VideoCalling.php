<?php

namespace App\Http\Livewire;

use App\Models\Section;
use Livewire\Component;

class VideoCalling extends Component
{
    public $name;
    public $email;
    public $room;
    public function mount($room)
    {
        $section = Section::find(request('section_id'));
        $this->room = $section->id.'-'.$section->course->name.'-'.$section->code;
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }
    public function render()
    {
        return view('livewire.video-calling')
            ->extends('layouts.master')
            ->section('content');
    }
}
