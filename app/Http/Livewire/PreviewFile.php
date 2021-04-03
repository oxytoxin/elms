<?php

namespace App\Http\Livewire;

use Livewire\Component;

class PreviewFile extends Component
{

    public $google_id;

    public function render()
    {
        return view('livewire.preview-file')
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount($id)
    {
        $this->google_id = $id;
    }
}