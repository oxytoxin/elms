<?php

namespace App\Http\Livewire\Dean;

use DB;
use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use App\Models\ProgramHead;
use Illuminate\Database\Eloquent\Builder;

class ProgramHeadManager extends Component
{

    protected $programheads;
    protected $departments;
    public $email = '';
    public $department_id = 0;
    public $showQuery = true;
    protected $teachers = [];

    public function mount()
    {
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function render()
    {
        if ($this->email) {
            $this->showQuery = true;
            $this->teachers = User::where('name', 'like', "%$this->email%")->whereHas('roles', function (Builder $query) {
                $query->where('role_id', 3);
            })->orWhere('email', 'like', "%$this->email%")->whereHas('roles', function (Builder $query) {
                $query->where('role_id', 3);
            })->get();
        } else {
            $this->showQuery = false;
            $this->teachers = collect();
        }
        if ($this->teachers->count() == 1 && $this->teachers->first()->email == $this->email) $this->showQuery = false;
        $this->programheads = ProgramHead::where('college_id', auth()->user()->dean->college_id)->get();
        $this->departments = auth()->user()->dean->college->departments()->doesntHave('program_head')->get();
        return view('livewire.dean.program-head-manager', [
            'programheads' => $this->programheads,
            'departments' => $this->departments,
            'teachers' => $this->teachers,
        ])
            ->extends('layouts.master')
            ->section('content');
    }

    public function assignProgramHead()
    {
        $this->validate([
            'email' => 'required|email',
            'department_id' => 'required|not_in:0'
        ]);
        $u = User::where('email', $this->email)->first();
        if (!$u) return session()->flash('error', 'Faculty member not found.');
        DB::transaction(function () use ($u) {
            ProgramHead::create([
                'user_id' => $u->id,
                'department_id' => $this->department_id,
                'college_id' => auth()->user()->dean->college_id,
            ]);
            $u->roles()->attach(Role::find(4));
        });
        $this->email = '';
        $this->department_id = 0;
        session()->flash('message', "Program head successfully assigned.");
    }
    public function removeProgramHead(ProgramHead $programhead)
    {
        $programhead->user->roles()->detach(Role::find(4));
        $programhead->delete();
        session()->flash('message', "Program head successfully removed.");
    }
}