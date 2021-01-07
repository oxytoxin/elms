<?php

namespace App\Http\Livewire;

use App\Events\NewMessage;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MessageBoard extends Component
{
    public $contact;
    public $message = "";
    protected $messages = [];

    public function getListeners()
    {
        return [
            "updatedConversation",
            "echo-private:messages.".Auth::id().",.new.message"  => '$refresh'
        ];
    }
    public function render()
    {
        if(!$this->contact)$this->messages = [];
        else $this->readMessage();
        return view('livewire.message-board',[
            'messages' => $this->messages,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function updatedConversation($contactId)
    {
        $this->contact = User::find($contactId);
    }

    public function sendMessage()
    {
        $this->validate([
            'message' => 'required'
        ]);
        $message = sanitizeString($this->message);
        Auth::user()->sendMessage($message,$this->contact->id);
        broadcast(new NewMessage($this->contact));
        $this->emit("refreshMessages");
        $this->message = "";
    }

    public function readMessage()
    {
        $this->messages = auth()->user()->contactMessages($this->contact->id)->orderByDesc('created_at')->get();
        // $this->messages->unread()->get()->each(function($m)
        // {
        //     if(!$m->read_at) $m->update(['read_at' => Carbon::now()]);
        // });
        // $this->messages = $this->messages->get();
    }
}
