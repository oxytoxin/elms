<?php

namespace App\Http\Livewire\Leina;

use App\Models\Support;
use Auth;
use Carbon\Carbon;
use Livewire\Component;

class Chatbot extends Component
{

    public $showChatbot = false;
    public $query = '';
    public $perPage = 10;

    public function render()
    {
        if(!Auth::check()) return redirect('login');
        return view('livewire.leina.chatbot', [
            'supports' => auth()->user()->supports->take($this->perPage),
        ]);
    }

    public function sendQuery()
    {
        $this->query = trim($this->query);
        $this->validate([
            'query' => 'required',
        ]);
        auth()->user()->supports()->create([
            'message' => $this->query,
            'isQuery' => true,
            'read_at' => Carbon::now(),
        ]);
        $this->query = '';
    }
}