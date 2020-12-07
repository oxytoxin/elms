<?php

namespace App\Http\Livewire\Head;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class FacultyManager extends Component
{
    use WithPagination;

    protected $teachers;

    public function render()
    {
        $department = auth()->user()->program_head->department;
        $this->teachers = $department->teachers()->addSelect([
            'name' => User::select('name')->whereColumn('id', 'user_id')->limit(1)
        ])->orderBy('name')->paginate(10);
        return view('livewire.head.faculty-manager', [
            'teachers' => $this->teachers,
        ])
            ->extends('layouts.master')
            ->section('content');
    }
}
