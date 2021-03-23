<?php

namespace App\Http\Livewire\Head;

use App\Models\User;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class FacultyManager extends Component
{
    use WithPagination;

    protected $teachers;
    protected $users;
    public $email = '';
    public $department_id;
    public $showQuery = false;


    public function mount()
    {
        $this->department_id = auth()->user()->program_head->departments->first()->id;
    }

    public function render()
    {
        $department = auth()->user()->program_head->departments->first();
        $this->teachers = $department ? $department->teachers()->addSelect([
            'name' => User::select('name')->whereColumn('id', 'user_id')->limit(1)
        ])->orderBy('name')->paginate(10) : collect([]);
        if ($this->email) {
            $this->showQuery = true;
            $this->users = User::where('name', 'like', "%$this->email%")->whereHas('roles', function (Builder $query) {
                $query->where('role_id', 3);
            })->orWhere('email', 'like', "%$this->email%")->whereHas('roles', function (Builder $query) {
                $query->where('role_id', 3);
            })->get();
        } else {
            $this->showQuery = false;
            $this->users = [];
        }
        return view('livewire.head.faculty-manager', [
            'teachers' => $this->teachers,
            'users' => $this->users,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function setEmail($email)
    {
        $this->email = $email;
        $this->addFaculty();
    }
    public function addFaculty()
    {
        $this->validate([
            'email' => 'required|email',
            'department_id' => 'required'
        ]);
        $u = User::where('email', $this->email)->first();
        if (!$u) return session()->flash('error', 'Faculty member not found.');
        $u->teacher->update([
            'department_id' => $this->department_id,
            'college_id' => auth()->user()->program_head->college_id,
        ]);
        $this->email = '';
        session()->flash('message', 'Faculty member was successfully added.');
    }

    public function removeFaculty(Teacher $teacher)
    {
        $teacher->update(['department_id' => null]);
        session()->flash('message', 'Faculty member removed.');
    }
}