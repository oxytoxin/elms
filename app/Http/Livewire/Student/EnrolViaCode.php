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
        $code = json_decode(base64_decode($this->invite_code), true);
        if (!$code) {
            session()->flash('error', 'Incorrect invite code.');
            return $this->alert('error', 'Incorrect invite code.', ['toast' => false, 'position' => 'center']);
        }
        if (array_key_exists('course_id', $code) && array_key_exists('teacher_id', $code) && array_key_exists('section_id', $code)) {
            DB::transaction(function () use ($code) {
                $section = Section::find($code['section_id']);
                if (!$section->students->contains(auth()->user()->student)) {
                    Teacher::find($code['teacher_id'])->students()->attach(auth()->user()->student, ['course_id' => $code['course_id'], 'section_id' => $code['section_id']]);
                    $section->chatroom->members()->attach(auth()->id());
                    $section->chatroom->messages()->create([
                        'sender_id' => null,
                        'message' => auth()->user()->name . ' has joined the group.'
                    ]);
                }
            });
        } else {
            session()->flash('error', 'Incorrect invite code.');
            return $this->alert('error', 'Incorrect invite code.', ['toast' => false, 'position' => 'center']);
        }

        $this->invite_code = '';
        return redirect()->route('student.home');
    }
}
