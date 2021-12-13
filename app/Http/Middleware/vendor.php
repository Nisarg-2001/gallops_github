<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class vendor
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
        
            if((session()->get('role'))==3)
            {
                return $next($request);
            }
            else
                return back();
    }
}
