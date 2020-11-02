<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\CalendarEvent;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskType;

class StudentPagesController extends Controller
{
    public function home()
    {
        $courses = auth()->user()->student->courses;
        return view('pages.student.index', compact('courses'));
    }
    public function modules()
    {
        $courses = auth()->user()->student->courses;
        return view('pages.student.modules.index', compact('courses'));
    }
    public function course_modules(Course $course)
    {
        $modules = $course->modules;
        return view('pages.student.modules.course_modules', compact('modules', 'course'));
    }
    public function module(Module $module)
    {
        $resources = $module->resources()->whereIn('teacher_id', auth()->user()->student->teachers)->get();
        return view('pages.student.modules.module', compact('module', 'resources'));
    }
    public function courses()
    {
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
        $events = $events->merge(CalendarEvent::where('level', 'all'));
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
