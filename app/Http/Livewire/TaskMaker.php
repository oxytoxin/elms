<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\Course;
use App\Models\Module;
use Livewire\Component;
use App\Models\TaskType;
use App\Models\CalendarEvent;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Builder;

class TaskMaker extends Component
{
    use WithFileUploads;
    public $type;
    public $task_name = "";
    public $module;
    public $modules;
    public $course;
    public $date_due;
    public $time_due = "23:59";
    public $items = [];
    public $questions = [];
    public $response = "";
    public $total_points = 0;
    public $files = [];

    protected $messages = [
        'items.*.question.required' => 'Question fields cannot be empty.',
        'items.*.answer.required' => 'Please select the correct option.',
        'items.*.options.*.required' => 'Option fields cannot be empty.',
        'items.*.points.min' => 'Item scores must be greater than 0.',
        'items.*.points.max' => 'Item scores must not be greater than 100.',
        'items.*.points.required' => 'Item scores are required.',
    ];


    public function mount()
    {
        $this->date_due = Carbon::tomorrow()->format('Y-m-d');
        $this->modules = Module::get();
        $this->module = Module::findOrFail(request('module'));
        $this->course = Course::findOrFail(request('course'));
        $this->type = request('type');
        array_push($this->items, [
            'files' => [],
            'question' => '',
            'points' => "1",
            'options' => [],
            'torf' => false,
        ]);
    }

    public function TorFtrigger($key)
    {
        $this->items[$key]['torf'] = !$this->items[$key]['torf'];
        // dd($this->items[$key]['TorF']);
        if ($this->items[$key]['torf']) {
            array_unshift($this->items[$key]['options'], "True", "False");
        } else {
            array_splice($this->items[$key]['options'], 0, 2);
        }
    }

    public function render()
    {
        $this->total_points = array_sum(array_column($this->items, 'points'));
        return view('livewire.task-maker')
            ->extends('layouts.master')
            ->section('content');
    }
    public function addItem($key)
    {
        $this->emit('item-added');
        array_push($this->items, [
            'files' => [],
            'question' => '',
            'points' => "1",
            'options' => [],
            'torf' => false,
        ]);
    }
    public function addOption($key)
    {
        array_push($this->items[$key]['options'], '');
    }
    public function removeOption($key, $id)
    {
        array_splice($this->items[$key]['options'], $id, 1);
    }
    public function removeItem($key)
    {
        array_splice($this->items, $key, 1);
    }
    public function saveTask()
    {
        for ($i = 0; $i < count($this->items); $i++) {
            $this->items[$i]['item_no'] = $i + 1;
        }
        $this->validate([
            'task_name' => 'required',
            'items.*.question' => 'required',
            'items.*.answer' => 'required',
            'items.*.options.*' => 'required',
            'items.*.points' => 'required|numeric|min:1|max:100',
            'items.*.files.*' => 'file'
        ]);
        foreach ($this->items as $key => $item) {
            foreach ($item['files'] as $id => $file) {
                $filename = $file->getClientOriginalName();
                $url = $file->store('tasks', 'public');
                $this->items[$key]['files'] = [];
                array_push($this->items[$key]['files'], ['name' => $filename, 'url' => $url]);
            }
        }
        $task = Task::create([
            'module_id' => $this->module->id,
            'teacher_id' => auth()->user()->teacher->id,
            'task_type_id' => TaskType::where('name', $this->type)->firstOrFail()->id,
            'name' => $this->task_name,
            'max_score' => $this->total_points,
            'content' => json_encode($this->items),
            'deadline' => $this->date_due . ' ' . $this->time_due,
        ]);
        $code = Carbon::now()->timestamp;
        CalendarEvent::create([
            'user_id' => auth()->user()->id,
            'code' => $code,
            'title' => $task->name,
            'description' => $task->name . ' for module: ' . $task->module->name,
            'level' => 'students',
            'start' => $this->date_due . ' ' . $this->time_due,
            'end' => Carbon::parse($this->date_due)->addDay()->format('Y-m-d'),
            'url' => '/task/' . $task->id,
            'allDay' => false
        ]);

        return redirect()->route('teacher.home');
        // $this->response = (string)json_encode($this->items);
    }
}
