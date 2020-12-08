<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Section;
use App\Models\Teacher;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;

class HeadCoursesPage extends Component
{
    use WithFileUploads;
    public $showEditCourse = false;
    public $course;
    public $sections;
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
        $this->sections = $this->course->sections;
    }


    public function render()
    {
        return view('livewire.head-courses-page');
    }

    public function removeSection(Section $section, $teacher_id)
    {
        $section->delete();
        if (!$this->course->sections()->where('teacher_id', $teacher_id)->get()->count()) {
            $this->course->teachers()->detach($teacher_id);
        }
        $this->sections =  Course::find($this->course->id)->sections;
        session()->flash('message', 'Section succesfully deleted.');
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
