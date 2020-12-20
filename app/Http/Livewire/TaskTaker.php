<?php

namespace App\Http\Livewire;

use App\Events\NewSubmission;
use App\Models\Task;
use Carbon\Carbon;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskTaker extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $task;
    public $hasExtension;
    public $answers = [];
    public $enumeration = [];
    public $task_content;
    public $hasSubmission;

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
        $this->hasExtension = auth()->user()->student->extensions()->where('task_id', $task->id)->first();
        $this->authorize('view', $task);
        $this->hasSubmission = $task->students->where('id', auth()->user()->student->id)->first();
        $this->task = $task;
        $this->task_content = json_decode($this->task->content, true);
        foreach ($this->task_content as $key => $content) {
            array_push($this->answers, ['answer' => '']);
            if ($content['enumeration']) $this->enumeration[$key] = [];
        }
    }

    public function submitAnswers()
    {
        if (auth()->user()->cannot('submit', $this->task)) return session()->flash('deadline', 'Unfortunately, this task has already been closed.');
        $count = count($this->task_content);

        foreach ($this->task_content as $key => $content) {
            if ($content['enumeration']) {
                if (count($this->enumeration[$key]) != count($content['enumerationItems'])) {
                    return session()->flash("enumError.$key", "Please enumerate all items required.");
                }
                $this->answers[$key]['answer'] = json_encode($this->enumeration[$key]);
            }
        }
        $this->validate([
            'answers.*.answer' => "required",
        ]);

        DB::transaction(function () {
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
            $this->task->students()->attach(auth()->user()->student->id, ['section_id' => $this->task->section_id, 'date_submitted' => Carbon::now()->format('Y-m-d H:i:s'), 'answers' => json_encode($this->answers)]);
            event(new NewSubmission(auth()->user()->student, $this->task->id));
        });
        return redirect()->route('student.tasks', ['task_type' => $this->task->task_type_id]);
    }
}
