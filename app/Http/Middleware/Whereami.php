<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Whereami
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
        if(Auth::check() && !session('whereami')) {
            switch (auth()->user()->roles()->first()->id) {
                case 2:
                    session(['whereami' => 'student']);
                    break;
                case 3:
                    session(['whereami' => 'teacher']);
                    break;
                case 4:
                    session(['whereami' => 'programhead']);
                    break;
                case 5:
                    session(['whereami' => 'dean']);
                    break;
            }
        }
        return $next($request);
    }
}
