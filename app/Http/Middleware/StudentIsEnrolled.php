<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentIsEnrolled
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
        if ($request->route('course')->students->where('id', auth()->user()->student->id)->first())
            return $next($request);
        return redirect()->route('student.home');
    }
}
