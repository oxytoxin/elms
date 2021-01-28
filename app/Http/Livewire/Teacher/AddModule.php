<?php

namespace App\Http\Livewire\Teacher;

use App\Models\Course;
use App\Models\Module;
use App\Models\Section;
use DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Carbon;

class AddModule extends Component
{

    use WithFileUploads;

    public $course;
    public $section;
    public $allSections = false;
    public $fileId = 0;
    public $moduleName = '';
    public $moduleFiles = [];


    protected $messages = [
        'moduleFiles.filled' => 'A file is required for a module.'
    ];

    public function render()
    {
        return view('livewire.teacher.add-module')
            ->extends('layouts.master')
            ->section('content');;
    }
    public function mount(Section $section)
    {
        $this->section = $section;
    }

    public function deleteModule(Module $module)
    {
        $module->delete();
        $this->section = Section::find($this->section->id);
        session()->flash('module_deleted', 'Module resources has been updated.');
    }

    public function addModule()
    {
        $this->validate([
            'moduleName' => 'required|string',
            'moduleFiles' => 'filled'
        ]);
        if ($this->allSections) {
            $sections = auth()->user()->teacher->sections()->where('course_id', $this->section->course_id)->get();
            $modulesArray = [];
            foreach ($sections as  $sect) {
                $mod = Module::create([
                    'section_id' => $sect->id,
                    'course_id' => $sect->course->id,
                    'name' => $this->moduleName
                ]);
                array_push($modulesArray, $mod);

                $rand = rand(1, 7);
                $mod->image()->create([
                    'url' => "/img/bg/bg($rand).jpg"
                ]);
            }
            foreach ($this->moduleFiles as  $k => $module) {
                $url = $module->store("", "google");
                $match = gdriver($url);
                foreach ($modulesArray as  $moduleItem) {
                    $moduleItem->files()->create([
                        'google_id' => $match['id'],
                        'name' => $module->getClientOriginalName(),
                        'url' => $url
                    ]);
                }
            }
        } else {
            DB::transaction(function () {
                $mod = Module::create([
                    'section_id' => $this->section->id,
                    'course_id' => $this->section->course->id,
                    'name' => $this->moduleName
                ]);
                foreach ($this->moduleFiles as  $module) {
                    $url = $module->store("", "google");
                    $match = gdriver($url);
                    $mod->files()->create([
                        'google_id' => $match['id'],
                        'name' => $module->getClientOriginalName(),
                        'url' => $url
                    ]);
                }
                $rand = rand(1, 7);
                $mod->image()->create([
                    'url' => "/img/bg/bg($rand).jpg"
                ]);
            });
        }

        $this->fileId++;
        $this->moduleName = "";
        $this->moduleFiles = [];
        $this->section = Section::find($this->section->id);
        session()->flash('message', 'Module has been added.');
    }
}
