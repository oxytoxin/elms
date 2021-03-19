<?php

namespace App\Http\Middleware;

use App\Models\Section;
use Closure;
use Illuminate\Http\Request;

class MeetingAuth
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
        $section = Section::find($request['section_id']);
        if (!$section) return redirect('/');
        if (!$section->videoroom) return redirect('/');
        if (auth()->user()->isTeacher()) {
            if ($section->teacher != auth()->user()->teacher) return redirect('/');
        } else if (auth()->user()->isStudent()) {
            if (!$section->students->contains(auth()->user()->student)) return redirect('/');
        }
        return $next($request);
    }
}