<?php

namespace App\Http\Livewire\Head;

use App\Models\User;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

class FacultyManager extends Component
{
    use WithPagination;

    protected $teachers;
    public $email = '';

    public function render()
    {
        $department = auth()->user()->program_head->department;
        $this->teachers = $department ? $department->teachers()->addSelect([
            'name' => User::select('name')->whereColumn('id', 'user_id')->limit(1)
        ])->orderBy('name')->paginate(10) : collect([]);
        return view('livewire.head.faculty-manager', [
            'teachers' => $this->teachers,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function addFaculty()
    {
        $this->validate([
            'email' => 'required|email',
        ]);
        $u = User::where('email', $this->email)->firstOrFail();
        $u->teacher->update(['department_id' => auth()->user()->program_head->department_id]);
        $this->email = '';
        session()->flash('message', 'Faculty member was successfully added.');
    }
}
