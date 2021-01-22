<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VideoCalling extends Component
{
    public $name;
    public $email;
    public function mount($room)
    {
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
