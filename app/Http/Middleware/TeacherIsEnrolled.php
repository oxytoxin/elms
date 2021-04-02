<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeacherIsEnrolled
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
        if ($request->route('section')->teacher_id == auth()->user()->teacher->id)
            return $next($request);
        return redirect()->route('teacher.modules');
    }
}