<?php

namespace App\Http\Livewire\Student;

use App\Models\Section;
use App\Models\Teacher;
use DB;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;

class EnrolViaCode extends Component
{
    public $invite_code = '';
    public function render()
    {
        return view('livewire.student.enrol-via-code')
            ->extends('layouts.master')
            ->section('content');
    }

    public function enroll()
    {
        $code = "";
        try {
            $code = Crypt::decrypt($this->invite_code);
        } catch (DecryptException $e) {
            abort(404);
        }
        DB::transaction(function () use ($code) {
            $section = Section::find($code['section_id']);
            if (!$section->students->contains(auth()->user()->student))
                Teacher::find($code['teacher_id'])->students()->attach(auth()->user()->student, ['course_id' => $code['course_id'], 'section_id' => $code['section_id']]);
        });
        $this->invite_code = '';
        return redirect()->route('student.home');
    }
}
