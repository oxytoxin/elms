<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProgramHeadPagesController extends Controller
{
    public function home()
    {
        $department = Auth::user()->program_head->department->id;
        $courses = Course::byDepartment($department)->get();
        return view('pages.head.index', compact('courses'));
    }
    public function modules()
    {
        $department = Auth::user()->program_head->department->id;
        $courses = Course::byDepartment($department)->get();
        return view('pages.head.modules.index', compact('courses'));
    }
    public function course_modules(Course $course)
    {
        $modules = $course->modules;
        return view('pages.head.modules.course_modules', compact('modules', 'course'));
    }
    public function module(Module $module)
    {
        return view('pages.head.modules.module', compact('module'));
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
        return view('pages.head.calendar');
    }
}
