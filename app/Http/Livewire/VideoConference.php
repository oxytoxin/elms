<?php

namespace App\Http\Livewire;

use App\Models\Videoroom;
use Livewire\Component;

class VideoConference extends Component
{
    public $name;

    public function getListeners()
    {
        return [
            'newUser' => 'saveUser'
        ];
    }

    public function mount()
    {
        $this->name = auth()->user()->name;
    }
    public function render()
    {
        return view('livewire.video-conference')
            ->extends('layouts.master')
            ->section('content');
    }

    public function saveUser($client)
    {
        dd(Videoroom::all());
        // Videoroom::create([
        //     'active_streams' => $client,
        // ]);
    }
}
