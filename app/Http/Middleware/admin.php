<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class admin
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
        if(Auth::check())
        {
            if(Auth::user()->isAdmin())
            {
                return $next($request);
            }
            else
            {
                return redirect('user/dashboard');
            }
                
        }
    }
}
