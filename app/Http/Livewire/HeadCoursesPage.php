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
    public $course;
    public $teachers;
    public $email = "";
    public $module;
    public $moduleName = "";
    public $fileId = 0;
    public $newCourseName = "";
    public $newCourseCode = "";

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
    public function addModule()
    {
        $this->validate([
            'moduleName' => 'required|string',
            'module' => 'required|file'
        ]);
        // $url = $this->module->storeAs("", Carbon::now()->format('Ymdhis') . $this->module->getClientOriginalName(), 'google');
        $url = $this->module->store("", "google");
        $match = gdriver($url);
        $mod = Module::create([
            'course_id' => $this->course->id,
            'name' => $this->moduleName
        ]);
        $mod->files()->create([
            'google_id' => $match['id'],
            'name' => $this->module->getClientOriginalName(),
            'url' => $url
        ]);
        $this->fileId++;
        $this->moduleName = "";
        $this->course = Course::find($this->course->id);
        session()->flash('message', 'Module has been added.');
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
        $this->dispatchBrowserEvent('course-updated');
        session()->flash('course_updates', 'Course has been updated.');
    }
    public function deleteCourse()
    {
        $this->course->teachers()->detach();
        $this->course->delete();
        return redirect('/');
    }
    public function deleteModule(Module $module)
    {
        $module->delete();
        $this->course = Course::find($this->course->id);
        session()->flash('module_deleted', 'Module resources has been updated.');
    }
}
