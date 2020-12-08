<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeanPagesController extends Controller
{
    public function home()
    {
        return view('pages.dean.index');
    }
}
