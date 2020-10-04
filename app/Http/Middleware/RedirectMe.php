<?php

namespace App\Http\Middleware;

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
        switch (auth()->user()->role_id) {
            case 2:
                return redirect()->route('student.home');
                break;
            case 3:
                return redirect()->route('teacher.home');
                break;
            case 4:
                return redirect()->route('head.home');
                break;
        }
    }
}
