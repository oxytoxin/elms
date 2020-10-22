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
    public $event_target = "personal";
    public $event_start_day = null;
    public $event_start_time = null;
    public $event_end_day = null;
    public $event_end_time = null;
    public $previous;

    public function mount()
    {
        $this->previous = URL::previous();
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
            } else {
                $end = $this->event_end_day;
            }
        } else $end = null;
        $code = Carbon::now()->timestamp;
        CalendarEvent::create([
            'user_id' => auth()->user()->id,
            'code' => $code,
            'title' => $this->event_name,
            'level' => $this->event_target,
            'start' => $start,
            'url' => '/event/' . $code,
            'end' => $end,
        ]);
        $this->event_name = "";
        $this->event_target = "personal";
        $this->event_start_day = null;
        $this->event_start_time = null;
        $this->event_end_day = null;
        $this->event_end_time = null;
        $this->dispatchBrowserEvent('event-created');
    }
}
