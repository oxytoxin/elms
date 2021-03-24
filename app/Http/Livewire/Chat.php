<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Chatroom;
use App\Events\NewMessage;
use App\Models\User;
use App\Providers\SendMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Chat extends Component
{
    private $chatrooms;
    public $current_chatroom;
    public $messageContent = "";
    public $search = "";
    public $perPage = 20;
    public $perContacts = 20;
    public $newMessage = false;
    public $newMessageContact;

    protected $rules = [
        'messageContent' => 'required',
    ];

    public function getListeners()
    {
        return [
            "echo-private:messages." . Auth::id() . ",.new.message"  => 'newMessageEvent'
        ];
    }

    public function newMessageEvent()
    {
        $this->dispatchBrowserEvent('message');
    }

    public function render()
    {
        $this->chatrooms = auth()->user()->chatrooms()->withLatest()->get()->sortByDesc('latestMessage.created_at');
        $contacts = User::where('name', 'like', "%$this->search%")->orWhere('email', 'like', "%$this->search%")->get();
        return view('livewire.chat', [
            'chatrooms' => $this->chatrooms,
            'messages' => $this->current_chatroom ? $this->current_chatroom->messages->take($this->perPage) : [],
            'contacts' => $contacts->take($this->perContacts),
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount()
    {
        $this->chatrooms = auth()->user()->chatrooms()->withLatest()->get()->sortByDesc('latestMessage.created_at');
        $this->current_chatroom = $this->chatrooms->first();
    }

    public function changeChatroom(Chatroom $chatroom)
    {
        $this->newMessage = false;
        $this->newMessageContact = null;
        $this->current_chatroom = $chatroom;
    }

    public function sendMessage()
    {
        $this->validate();
        if (!$this->current_chatroom && !$this->newMessage) return;
        if ($this->newMessage) $this->createNewContact();
        $this->current_chatroom->messages()->create([
            'sender_id' => auth()->id(),
            'message' => sanitizeString($this->messageContent),
        ]);
        $this->messageContent = '';
        if ($this->current_chatroom->isGroup) event(new SendMessage($this->current_chatroom->members, auth()->id()));
        else broadcast(new NewMessage($this->current_chatroom->receiver));
        $this->current_chatroom = Chatroom::find($this->current_chatroom->id);
    }

    public function sendToNewContact($contact)
    {
        if ($contact['id'] == auth()->id()) return $this->alert('error', 'You cannot send to yourself.');
        $chatroom = auth()->user()->chatrooms->where('isGroup', false)->where('receiver.id', $contact['id'])->first();
        if ($chatroom) return $this->current_chatroom = $chatroom;
        $this->newMessage = true;
        $this->newMessageContact = $contact;
        $this->current_chatroom = null;
    }

    public function createNewContact()
    {
        if ($this->newMessageContact) {
            $c = Chatroom::create();
            $c->members()->attach([auth()->id(), $this->newMessageContact['id']]);
            $this->current_chatroom = $c;
        }
    }
}