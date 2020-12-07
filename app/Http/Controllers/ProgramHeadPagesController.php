<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CalendarEvent;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgramHeadPagesController extends Controller
{
    public function home()
    {
        $department = Auth::user()->program_head->department->id;
        $sections = Section::byDepartment($department)->with('course')->get();
        return view('pages.head.index', compact('sections'));
    }
    public function modules()
    {
        $department = Auth::user()->program_head->department->id;
        $courses = Course::byDepartment($department)->get();
        return view('pages.head.modules.index', compact('courses'));
    }
    public function course_modules(Section $section)
    {
        $modules = $section->modules;
        return view('pages.head.modules.course_modules', compact('modules', 'section'));
    }
    public function module(Module $module)
    {
        $resources = $module->resources()->get();
        return view('pages.head.modules.module', compact('module', 'resources'));
    }
    public function courses()
    {
        $department = Auth::user()->program_head->department->id;
        $courses = Course::byDepartment($department)->get();
        return view('pages.head.courses.index', compact('courses'));
    }
    public function course(Course $course)
    {
        return view('pages.head.courses.course', compact('course'));
    }
    public function create_course()
    {
        return view('pages.head.courses.create');
    }
    public function preview(File $file)
    {
        return view('pages.head.preview', compact('file'));
    }
    public function calendar()
    {
        $events = auth()->user()->calendar_events;
        $events = $events->merge(CalendarEvent::where('level', 'all')->get());
        return view('pages.head.calendar', compact('events'));
    }
}
