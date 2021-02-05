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
    public $messageValue = "";
    public $messageCount = 10;
    protected $messages = [];

    public function getListeners()
    {
        return [
            "updatedConversation",
            "moreMessage",
            "echo-private:messages." . Auth::id() . ",.new.message"  => '$refresh'
        ];
    }
    public function render()
    {
        if (!$this->contact) $this->messages = [];
        else $this->readMessage();
        return view('livewire.message-board', [
            'messages' => $this->messages,
        ])
            ->extends('layouts.master')
            ->section('content');
    }


    public function moreMessage()
    {
        $this->messageCount = $this->messageCount + 10;
    }

    public function updatedConversation($contactId)
    {
        $this->messageCount = 10;
        $this->contact = User::find($contactId);
    }

    public function sendMessage()
    {
        if ($this->contact) {
            $this->validate([
                'messageValue' => 'required'
            ]);
            $message = sanitizeString($this->messageValue);
            Auth::user()->sendMessage($message, $this->contact->id);
            broadcast(new NewMessage($this->contact));
            $this->emit("refreshMessages");
            $this->messageValue = "";
        }
    }

    public function readMessage()
    {
        if (auth()->user()->contactMessages($this->contact->id)->count())
            $this->messages = auth()->user()->contactMessages($this->contact->id)->orderByDesc('created_at')->get()->take($this->messageCount);
        else $this->messages = [];
    }
}