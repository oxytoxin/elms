<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Http\Controllers\Controller;
use App\Models\TaskType;

class TeacherPagesController extends Controller
{
    public function home()
    {
        $courses = auth()->user()->teacher->courses;
        return view('pages.teacher.index', compact('courses'));
    }
    public function modules()
    {
        $courses = auth()->user()->teacher->courses;
        return view('pages.teacher.modules.index', compact('courses'));
    }
    public function course_modules(Course $course)
    {
        $modules = $course->modules;
        return view('pages.teacher.modules.course_modules', compact('modules', 'course'));
    }
    public function module(Module $module)
    {
        $task_types = TaskType::get();
        $resources = $module->resources()->where('teacher_id', auth()->user()->teacher->id)->get();
        return view('pages.teacher.modules.module', compact('module', 'task_types', 'resources'));
    }
    public function courses()
    {
    }
    public function course(Course $course)
    {
        return view('pages.teacher.courses.course', compact('course'));
    }
    public function create_course()
    {
        return view('pages.teacher.courses.create');
    }
    public function preview(File $file)
    {
        return view('pages.teacher.preview', compact('file'));
    }
    public function calendar()
    {
        $events = auth()->user()->calendar_events;
        $events = $events->merge(CalendarEvent::where('level', 'all'));
        $events = $events->merge(CalendarEvent::where('level', 'faculty'));
        return view('pages.teacher.calendar', compact('events'));
    }
}
