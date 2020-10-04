<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
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

    public function mount()
    {
        $this->teachers =  $this->course->teachers->reverse();
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
    public function addModule()
    {
        $this->validate([
            'moduleName' => 'required|string',
            'module' => 'required|file'
        ]);
        $url = $this->module->storeAs("", Carbon::now()->format('Ymdhis') . $this->module->getClientOriginalName(), 'google');
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
}
