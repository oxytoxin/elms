<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Task;
use App\Models\Course;
use App\Models\Module;
use App\Models\Section;
use App\Models\TaskType;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class StudentPagesController extends Controller
{
    public function home()
    {
        session(['whereami' => 'student']);
        $sections = auth()->user()->student->sections()->paginate(20);
        return view('pages.student.index', compact('sections'));
    }
    public function modules()
    {
        $sections = auth()->user()->student->sections()->paginate(5);
        return view('pages.student.modules.index', compact('sections'));
    }
    public function course_modules(Section $section)
    {
        $modules = $section->modules;
        return view('pages.student.modules.course_modules', compact('modules', 'section'));
    }
    public function module(Module $module)
    {
        $toOrient = $module->section->modules()->first()->id === $module->id && !auth()->user()->orientations()->where('section_id', $module->section->id)->first();
        if ($module->section->modules()->first()->id !== $module->id && !auth()->user()->orientations()->where('section_id', $module->section->id)->first()) {
            $module = $module->section->modules()->with('resources')->first();
            return redirect()->route('student.course_modules', ['section' => $module->section->id, 'orient' => true]);
        }
        return view('pages.student.modules.module', compact('module', 'toOrient'));
    }
    public function course(Course $course)
    {
        return view('pages.student.courses.course', compact('course'));
    }
    public function create_course()
    {
        return view('pages.student.courses.create');
    }
    public function preview(File $file)
    {
        return view('pages.student.preview', compact('file'));
    }
    public function calendar()
    {
        $events = auth()->user()->calendar_events;
        $events = $events->merge(CalendarEvent::where('level', 'all')->get());
        $events = $events->merge(auth()->user()->student->teachers->map(function ($t) {
            return $t->user->calendar_events->where('level', 'students');
        })->flatten());
        return view('pages.student.calendar', compact('events'));
    }
    public function tasks($task_type)
    {
        $tasks = auth()->user()->student->tasksByType($task_type);
        $task_type = TaskType::find($task_type);
        return view('pages.student.tasks', compact('tasks', 'task_type'));
    }
}