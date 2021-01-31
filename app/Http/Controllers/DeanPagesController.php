<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeanPagesController extends Controller
{
    public function home()
    {
        session(['whereami' => 'dean']);
        return view('pages.dean.index');
    }
}
