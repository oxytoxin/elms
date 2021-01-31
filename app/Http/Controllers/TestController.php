<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $file = $request->file('file')->storeAs('', $request->file('file')->getClientOriginalName() . Carbon::now(), 'google');
        $match = gdriver($file);
        return view('test', compact('match'));
    }
}
