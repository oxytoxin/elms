<?php

namespace App\Http\Livewire\Layouts;

use App\Models\CalendarEvent;
use App\Models\Todo;
use Livewire\Component;

class Sidelist extends Component
{

    public $todos;
    public $events;
    public $upcoming;
    public $todo = "";
    public $showAdd = false;

    public function mount()
    {
        $this->todos = auth()->user()->todos->sortByDesc('created_at');
        $this->events = CalendarEvent::where('level', 'all')->get();
        if (auth()->user()->isStudent()) {
            $this->upcoming = auth()->user()->student->allTasks->take(5)->sortByDesc('deadline');
        }
    }


    public function toggleAdd()
    {
        $this->showAdd = true;
    }

    public function markAsDone(Todo $todo)
    {
        $todo->update([
            'completed' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.layouts.sidelist');
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
        $this->todos = auth()->user()->todos->sortByDesc('created_at');
    }

    public function removeTodo(Todo $todo)
    {
        $todo->delete();
        $this->todos = auth()->user()->todos->sortByDesc('created_at');
    }
}
