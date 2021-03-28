<?php

namespace App\Http\Livewire;

use Event;
use Livewire\Component;

class EventsList extends Component
{
    public $eventsListOpen = false;
    public $events;

    protected $listeners = ['openEventsList'];

    public function openEventsList()
    {
        $this->eventsListOpen = true;
    }

    public function render()
    {
        $this->events = auth()->user()->calendar_events()->get();
        return view('livewire.events-list');
    }

    public function removeEvent($event_id)
    {
        auth()->user()->calendar_events()->where('id', $event_id)->first()->delete();
        $this->dispatchBrowserEvent('events-changed');
        return $this->alert('success', 'Event successfully deleted.', ['toast' => false, 'position' => 'center']);
    }
}