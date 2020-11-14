<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaskTaker extends Component
{
    use WithFileUploads;
    public $task;
    public $answers = [];
    public $task_content;

    protected $messages = [
        'answers.*.answer.required' => 'You forgot to answer this item.',
        'answers.required' => 'Please answer all items.',
        'answers.size' => 'Please answer all items.'
    ];

    public function render()
    {
        return view('livewire.task-taker')
            ->extends('layouts.master')
            ->section('content');
    }

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->task_content = json_decode($this->task->content, true);
    }

    public function submitAnswers()
    {
        $count = count($this->task_content);
        $this->validate([
            'answers' => "size:$count|required",
        ]);
        foreach ($this->answers as $key => $item) {
            if (isset($item['files'])) {
                foreach ($item['files'] as $id => $file) {
                    $filename = $file->getClientOriginalName();
                    $url = $file->store('tasks', 'public');
                    $this->answers[$key]['files'] = [];
                    array_push($this->answers[$key]['files'], ['name' => $filename, 'url' => $url]);
                }
            }
        }
        $this->task->students()->attach(auth()->user()->id, ['date_submitted' => Carbon::now()->format('Y-m-d H:i:s'), 'answers' => json_encode($this->answers)]);
        return redirect()->route('student.tasks', ['task_type' => $this->task->task_type_id]);
    }
}
