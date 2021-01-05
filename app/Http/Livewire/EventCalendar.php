<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CalendarEvent;

class EventCalendar extends Component
{
    public function render()
    {
        return view('livewire.event-calendar')
            ->extends('layouts.master')
            ->section('content');
    }
}
