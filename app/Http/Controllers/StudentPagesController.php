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
    public function module(Module $module)
    {
        return view('pages.student.modules.module', compact('module'));
    }
}
