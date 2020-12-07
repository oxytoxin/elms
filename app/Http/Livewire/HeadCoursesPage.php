<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Teacher;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class HeadCoursesPage extends Component
{
    use WithFileUploads;
    public $tab = 'faculty';
    public $showEditCourse = false;
    public $course;
    public $teachers;
    public $email = "";
    public $newCourseName = "";
    public $newCourseCode = "";


    protected $messages = [
        'newCourseCode.regex' => "The format is invalid. Please follow \"ABC123\" pattern."
    ];

    public function mount()
    {
        $this->teachers =  $this->course->teachers->reverse();
        $this->newCourseName = $this->course->name;
        $this->newCourseCode = $this->course->code;
    }


    public function render()
    {
        return view('livewire.head-courses-page');
    }
    public function enrolFaculty()
    {
        $teacher = User::has('teacher')->where('email', $this->email)->firstOrFail()->teacher;
        if (!$this->course->teachers->contains($teacher)) {
            $this->course->teachers()->attach($teacher->id);
            $this->teachers =  Course::find($this->course->id)->teachers->reverse();
            $this->email = "";
            session()->flash('message', 'Faculty member succesfully enrolled.');
        } else session()->flash('message', 'Faculty member already enrolled.');
    }
    public function removeFaculty(Teacher $teacher)
    {
        $this->course->teachers()->detach($teacher);
        $this->teachers =  Course::find($this->course->id)->teachers->reverse();
        session()->flash('message', 'Faculty member succesfully removed.');
    }

    public function editCourse()
    {
        $this->validate([
            'newCourseName' => 'required|string',
            'newCourseCode' => ['required', 'regex:/^[a-zA-Z]{3}\d{3}$/']
        ]);
        $this->course->update([
            'name' => strtoupper($this->newCourseName),
            'code' => strtoupper($this->newCourseCode),
        ]);
        $this->course = Course::find($this->course->id);
        $this->newCourseName = $this->course->name;
        $this->newCourseCode = $this->course->code;
        $this->showEditCourse = false;
        $this->dispatchBrowserEvent('course-updated');
        session()->flash('course_updates', 'Course has been updated.');
    }
    public function deleteCourse()
    {
        $this->course->teachers()->detach();
        $this->course->delete();
        return redirect('/');
    }
}
