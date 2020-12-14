<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Extension;
use App\Models\Student;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ExtendDeadline extends Component
{
    public $task;
    public $selected_students;
    public $scope = 'all';
    public $days = 1;
    public $email;

    public function render()
    {
        return view('livewire.teacher.extend-deadline')
            ->extends('layouts.master')
            ->section('content');;
    }

    public function mount(Task $task)
    {
        $this->task = $task;
        $this->selected_students = new Collection();
    }

    public function addStudent()
    {
        $u = User::where('email', $this->email)->first();
        if (!$u) return session()->flash('error', 'No student found with that email.');
        $this->selected_students->push($u->student);
        $this->email = "";
        return session()->flash('message', 'Student successfully added.');
    }

    public function extendDeadline()
    {
        switch ($this->scope) {
            case 'all':
                $this->task->update([
                    'deadline' => $this->task->deadline->addDays($this->days)
                ]);
                break;
            case 'selected':
                if (!$this->selected_students->count()) return session()->flash('error', 'You need to add at least one student.');
                foreach ($this->selected_students as $student) {
                    $ext = $this->task->extensions()->where('student_id', $student->id)->first();
                    if (!$ext)
                        $student->extensions()->create([
                            'task_id' => $this->task->id,
                            'deadline' => $this->task->deadline->addDays($this->days),
                        ]);
                    else
                        $ext->update(['deadline' => $ext->deadline->addDays($this->days),]);
                }
                break;

            default:
                return;
                break;
        }
        return redirect()->route('teacher.task', ['task' => $this->task->id]);
    }
}
