<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreateCourse extends Component
{

    public $course_title = '';
    public $course_code = '';
    public $course_image;
    public $fileId = 0;

    public function render()
    {
        return view('livewire.create-course');
    }
    public function addCourse()
    {
        $this->validate([
            'course_title' => 'required|string',
            'course_code' => 'required|string',
        ]);
        Course::create([
            'code' => $this->course_code,
            'name' => $this->course_title,
            'college_id' => Auth::user()->program_head->college_id,
            'department_id' => Auth::user()->program_head->department_id,
        ]);
        $this->course_title = "";
        $this->course_code = "";
        session()->flash('message', 'Course has been added.');
    }
}
