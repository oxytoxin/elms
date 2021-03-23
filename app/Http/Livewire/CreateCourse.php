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
    public $course_units = 3.00;
    public $course_image;
    public $fileId = 0;
    public $department_id = "";

    protected $messages = [
        'course_code.regex' => "The format is invalid. Please follow \"ABC123\" pattern."
    ];

    public function render()
    {
        return view('livewire.create-course');
    }
    public function addCourse()
    {
        $this->validate([
            'department_id' => 'required',
            'course_title' => 'required|string',
            'course_code' => ['required', 'regex:/^[a-zA-Z]{3}\d{3}$/'],
            'course_units' => ['required', 'numeric', 'min:1'],
        ]);
        $course = Course::create([
            'code' => strtoupper($this->course_code),
            'name' => strtoupper($this->course_title),
            'units' => $this->course_units,
            'department_id' => $this->department_id,
            // 'college_id' => Auth::user()->program_head->college_id,
        ]);
        $rand = rand(1, 7);
        $course->image()->create([
            'url' => "/img/bg/bg($rand).jpg"
        ]);
        $this->course_title = "";
        $this->course_code = "";
        session()->flash('message', 'Course has been added.');
    }
}