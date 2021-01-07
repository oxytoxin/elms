<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Message;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MessageContacts extends Component
{
    public $perpage = 10;
    public $showContactSearch = false;
    public $searchContact = "";

    public function getListeners()
    {
        return [
            "loadMore",
            "updatedConversation" => '$refresh',
            "echo-private:messages.".Auth::id().",.new.message"  => '$refresh',
            "refreshMessages" => '$refresh'
        ];
    }



    public function render()
    {
        if(!Auth::check()) return redirect('login');
        $contacts = User::query();

        if($this->searchContact) $contacts = $contacts->where('name','like',"%$this->searchContact%")->get();
        else $contacts = $contacts->get()->take(10);

        return view('livewire.message-contacts',[
            'latest_messages' => auth()->user()->latest_messages->take($this->perpage),
            'contacts' => $contacts,
        ]);
    }

    public function loadMore()
    {
        if($this->showContactSearch) return;
        if(auth()->user()->latest_messages->count() <= $this->perpage) return;
        $this->perpage = $this->perpage + 5;
    }

    public function newMessage()
    {
        Message::factory()->create(['receiver_id' => Auth::id()]);
    }

    public function openContactSearch()
    {
        $this->showContactSearch = true;
    }
    public function closeContactSearch()
    {
        $this->showContactSearch = false;
        $this->searchContact = "";
    }

    public function contactClicked($contactId)
    {
        Auth::user()->contactMessages($contactId)->update(['read_at' => Carbon::now()]);
        $this->emit("updatedConversation", $contactId);
    }
}
