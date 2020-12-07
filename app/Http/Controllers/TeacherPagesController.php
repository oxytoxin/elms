<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Task;
use App\Models\Course;
use App\Models\Module;
use App\Models\TaskType;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Http\Controllers\Controller;
use App\Models\Section;

class TeacherPagesController extends Controller
{
    public function home()
    {
        $sections = auth()->user()->teacher->sections()->with('course')->get();
        return view('pages.teacher.index', compact('sections'));
    }
    public function modules()
    {
        $sections = auth()->user()->teacher->sections()->with('course')->get();
        return view('pages.teacher.modules.index', compact('sections'));
    }
    public function course_modules(Section $section)
    {
        $modules = $section->modules;
        return view('pages.teacher.modules.course_modules', compact('modules', 'section'));
    }
    public function module(Module $module)
    {
        $task_types = TaskType::get();
        $resources = $module->resources()->where('teacher_id', auth()->user()->teacher->id)->get();
        return view('pages.teacher.modules.module', compact('module', 'task_types', 'resources'));
    }
    public function course(Course $course, Request $request)
    {
        $section = Section::find($request->section);
        return view('pages.teacher.courses.course', compact('course', 'section'));
    }
    public function preview(File $file)
    {
        return view('pages.teacher.preview', compact('file'));
    }
    public function calendar()
    {
        $events = auth()->user()->calendar_events;
        $events = $events->merge(CalendarEvent::where('level', 'all')->get());
        $events = $events->merge(CalendarEvent::where('level', 'faculty')->get());
        return view('pages.teacher.calendar', compact('events'));
    }
    public function tasks($task_type)
    {
        $tasks = auth()->user()->teacher->tasks()->where('task_type_id', $task_type)->paginate(10);
        $task_type = TaskType::find($task_type);
        return view('pages.teacher.tasks', compact('tasks', 'task_type'));
    }
    public function task()
    {
        return view('pages.teacher.task');
    }
}
