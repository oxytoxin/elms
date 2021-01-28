<?php

namespace App\Http\Livewire\Layouts;

use App\Models\CalendarEvent;
use App\Models\Todo;
use Livewire\Component;

class Sidelist extends Component
{

    public $todos;
    public $events;
    public $todo = "";
    public $showAdd = false;
    public $user_id;

    public function render()
    {
        $upcoming = [];
        if (auth()->user()->isStudent()) {
            $upcoming = auth()->user()->student->allTasks->whereNotNull('deadline')->take(5)->sortBy('deadline');
        }
        return view('livewire.layouts.sidelist', [
            'upcoming' => $upcoming,
        ]);
    }

    public function getListeners()
    {
        return [
            "echo-private:users.{$this->user_id},.Illuminate\Notifications\Events\BroadcastNotificationCreated" => '$refresh',
        ];
    }

    public function mount()
    {
        $this->user_id = auth()->user()->id;
        $this->todos = auth()->user()->todos->sortByDesc('created_at');
        $this->events = CalendarEvent::where('level', 'all')->get()->take(4)->sortBy('start');
    }


    public function markAsDone(Todo $todo)
    {
        $todo->update([
            'completed' => true,
        ]);
        $this->todos = auth()->user()->todos->sortByDesc('created_at');
    }


    public function addTodo()
    {
        $this->validate([
            'todo' => 'required|min:5'
        ]);
        auth()->user()->todos()->create([
            'content' => $this->todo,
        ]);
        $this->todo = "";
        $this->showAdd = false;
        $this->todos = auth()->user()->todos->sortByDesc('created_at');
        $this->dispatchBrowserEvent('toast', ['type' => 'success', 'message' => 'Todo added!']);
    }

    public function removeTodo(Todo $todo)
    {
        $todo->delete();
        $this->todos = auth()->user()->todos->sortByDesc('created_at');
    }
}
