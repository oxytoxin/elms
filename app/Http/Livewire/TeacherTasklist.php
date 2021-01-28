<?php

namespace App\Http\Livewire;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TeacherTasklist extends Component
{
    use WithPagination;
    public $submissions;
    public $task;
    public $submissionFilter = "all";
    protected $students;
    public $search = "";
    public $showDeadlineExtension = false;
    public function render()
    {
        $query = $this->task->students();
        if($this->search) $query = $query->whereHas('user',function($q){
            $q->where('name','like',"%$this->search%");
        });
        switch ($this->submissionFilter) {
            case 'graded':
                $query = $query->where('isGraded',true);
                break;
            case 'ungraded':
                $this->students = $query->where('isGraded',false);
                break;
            default:
                break;
        }
        $this->students = $query->orderBy('date_submitted', 'desc')->paginate(10);
        return view('livewire.teacher-tasklist', [
            'students' => $this->students,
        ])
            ->extends('layouts.master')
            ->section('content');
    }
    public function mount(Task $task)
    {
        $this->task = $task;
    }
}
