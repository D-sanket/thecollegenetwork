<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth as DefaultAuth;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(DefaultAuth::check())
            return redirect('/')->withErrors('You are already logged in.');
        return $next($request);
    }
}
