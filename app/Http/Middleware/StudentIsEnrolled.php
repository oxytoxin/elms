<?php

namespace App\Http\Middleware;

use App\Models\Section;
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
        if (Section::find($request->route('section'))?->students()->where('student_id', auth()->user()->student->id)->first())
            return $next($request);
        return redirect()->route('student.home');
    }
}
