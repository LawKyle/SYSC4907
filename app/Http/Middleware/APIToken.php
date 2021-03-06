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
         if(Cookie::has('auth_token') && !empty(Cookie::get('auth_token'))) {
            var_dump("pass"); 
            return redirect("/tappedProducts"); 
        }
        return $next($request); 
    }
}
