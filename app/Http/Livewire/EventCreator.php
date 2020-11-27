<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CalendarEvent;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\URL;

class EventCreator extends Component
{
    public $event_name = "";
    public $event_description = "";
    public $event_target = "personal";
    public $event_start_day = null;
    public $event_start_time = null;
    public $event_end_day = null;
    public $event_end_time = null;
    public $creatorOpen = false;

    protected $listeners = ['openEventCreator'];

    public function openEventCreator()
    {
        $this->creatorOpen = true;
    }

    public function render()
    {
        return view('livewire.event-creator');
    }

    public function addEvent()
    {
        $this->validate([
            'event_name' => 'required',
            'event_start_day' => 'required',
        ]);
        if ($this->event_start_time) {
            $start = $this->event_start_day . ' ' . $this->event_start_time;
        } else {
            $start = $this->event_start_day;
        }
        if ($this->event_end_day) {
            if ($this->event_end_time) {
                $end = $this->event_end_day . ' ' . $this->event_end_time;
                $allDay = false;
            } else {
                $allDay = true;
                $end = Carbon::parse($this->event_end_day)->addDay()->format('Y-m-d');
            }
        } else {
            $end = null;
            $allDay = true;
        };
        $code = Carbon::now()->timestamp;
        CalendarEvent::create([
            'user_id' => auth()->user()->id,
            'code' => $code,
            'title' => $this->event_name,
            'description' => $this->event_description,
            'level' => $this->event_target,
            'start' => $start,
            'url' => '/event/' . $code,
            'end' => $end,
            'allDay' => $allDay,
        ]);
        $this->event_name = "";
        $this->event_target = "personal";
        $this->event_start_day = null;
        $this->event_start_time = null;
        $this->event_end_day = null;
        $this->event_end_time = null;
        $this->creatorOpen = false;
        $this->dispatchBrowserEvent('event-created');
    }
}
