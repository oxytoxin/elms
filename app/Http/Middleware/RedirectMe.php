<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class RedirectMe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            switch (auth()->user()->roles()->first()->id) {
                case 2:
                    session(['whereami' => 'student']);
                    return redirect()->route('student.home');
                    break;
                case 3:
                    session(['whereami' => 'teacher']);
                    return redirect()->route('teacher.home');
                    break;
                case 4:
                    session(['whereami' => 'programhead']);
                    return redirect()->route('head.home');
                    break;
                case 5:
                    session(['whereami' => 'dean']);
                    return redirect()->route('dean.home');
                    break;
            }
        } else {
            return redirect()->route('login');
        }
        return response('Error');
    }
}