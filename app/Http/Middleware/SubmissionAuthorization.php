<?php

namespace App\Http\Middleware;

use App\Models\StudentTask;
use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionAuthorization
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
            if (!(bool)Auth::user()->roles()->find(3) && !(bool)Auth::user()->roles()->find(2)) return redirect('/redirectMe');
        }
        $submission = StudentTask::find($request->route('submission'));
        if (!$submission) abort(404);
        if (auth()->user()->isStudent()) {
            if ($submission->student_id !== auth()->user()->student->id) return redirect('/redirectMe');
        } elseif (auth()->user()->isTeacher()) {
            if ($submission->task->teacher_id !== auth()->user()->teacher->id) return redirect('/redirectMe');
        }
        return $next($request);
    }
}
