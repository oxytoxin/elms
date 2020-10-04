<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class StudentPagesController extends Controller
{
    public function home()
    {
        return view('pages.student.index');
    }
    public function modules()
    {
        return view('pages.student.modules.index');
    }
    public function course_modules(Course $course)
    {
        return view('pages.student.modules.course_modules');
    }
    public function module(Module $module)
    {
        return view('pages.student.modules.module');
    }
    public function courses()
    {
    }
    public function course(Course $course)
    {
        return view('pages.student.courses.course');
    }
    public function create_course()
    {
        return view('pages.student.courses.create');
    }
    public function preview(File $file)
    {
        return view('pages.student.preview');
    }
}
