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
    public $hasAttempted = false;
    public $unanswered = [];
    public $answers = [];
    public $enumeration = [];
    public $task_content;
    public $hasSubmission;
    public $matchingTypeOptions;

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
        if ($task->matchingtype_options) $this->matchingTypeOptions = json_decode($task->matchingtype_options, true);
        $this->task_content = json_decode($this->task->content, true);
        shuffle($this->task_content);
        foreach ($this->task_content as $key => $content) {
            array_push($this->answers, ['answer' => '', 'files' => [], 'item_no' => $content['item_no']]);
            if ($content['enumeration']) $this->enumeration[$key] = ['item_no' => $content['item_no'], 'items' => []];
        }
    }

    public function getIdentifier($item)
    {
        if ($item['essay']) return '(Essay)';
        if ($item['enumeration']) return '(Enumeration)';
        if ($item['attachment']) return '(File required.)';
        if ($item['torf']) return '(True or False.)';
    }

    public function submitAnswers()
    {
        if (auth()->user()->cannot('submit', $this->task)) return session()->flash('deadline', 'Unfortunately, this task has already been closed.');
        $count = count($this->task_content);
        $c = collect($this->task_content);
        $tc = $c->sortBy('item_no')->values()->all();
        $a = collect($this->answers);
        $ta = $a->sortBy('item_no')->values()->all();
        $te = collect($this->enumeration)->keyBy(function ($e) {
            return $e['item_no'] - 1;
        })->sortKeys()->all();
        foreach ($tc as $key => $content) {
            if ($content['enumeration']) {
                if (count($te[$key]['items']) != count($content['enumerationItems'])) {
                    return $this->alert('error', 'You have incomplete enumeration items unanswered.', [
                        'position' => 'center',
                        'toast' => false,
                        'timer' => 3000,
                        'text' => 'Please go back and answer them.',
                        'showConfirmButton' =>  true,
                        'confirmButtonText' =>  'Ok',
                    ]);
                }
            }
        }
        foreach ($tc as $key => $content) {
            if ($content['enumeration']) {
                $ta[$key]['answer'] = json_encode($te[$key]);
            }
        }
        foreach ($ta as $key => $item) {
            if (isset($item['files']) && $item['files'] != []) {
                if (sanitizeString($item['answer']) == "") $ta[$key]['answer'] = 'File attached.';
            }
        }
        $unanswered = collect($ta)->filter(function ($a, $k) use ($tc) {
            if ($tc[$k]['attachment']) {
                return empty($a['files']);
            }
            return $a['answer'] == "";
        });
        if ($unanswered->count()) {
            $this->hasAttempted = true;
            $this->unanswered = $unanswered->keyBy('item_no')->keys()->all();
            return $this->alert('error', 'You have some items unanswered.', [
                'position' => 'center',
                'toast' => false,
                'timer' => 3000,
                'text' => 'Please go back and answer all items.',
                'showConfirmButton' =>  true,
                'confirmButtonText' =>  'Ok',
            ]);
        }
        $this->hasAttempted = true;
        $this->task_content = $tc;
        $this->answers = $ta;
        foreach ($this->answers as $key => $item) {
            if (isset($item['files'])) {
                $this->answers[$key]['files'] = [];
                foreach ($item['files'] as $id => $file) {
                    $filename = $file->getClientOriginalName();
                    $url = $file->store("", "tasks");
                    $match = gdriver($url);
                    array_push($this->answers[$key]['files'], ['name' => $filename, 'google_id' => $match['id'], 'url' => $url]);
                }
            }
        }
        $submission = (bool) $this->task->students()->wherePivot('student_id', auth()->user()->student->id)->wherePivot('task_id', $this->task->id)->first();
        if (!$submission) {
            DB::transaction(function () {
                $this->task->students()->attach(auth()->user()->student->id, [
                    'section_id' => $this->task->section_id,
                    'date_submitted' => Carbon::now()->format('Y-m-d H:i:s'),
                    'answers' => json_encode($this->answers)
                ]);
            });
            event(new NewSubmission(auth()->user()->student, $this->task->id));
        }
        session()->flash('message', 'Task was successfully submitted.');
        return redirect()->route('student.tasks', ['task_type' => $this->task->task_type_id]);
    }
}