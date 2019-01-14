<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cookie; 

use Closure;

class APIToken
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
         if(Cookie::has('token') && !empty(Cookie::get('token'))) {
            var_dump("pass"); 
            return redirect("/department/1/tappedProducts"); 
        }
        return $next($request); 
    }
}
