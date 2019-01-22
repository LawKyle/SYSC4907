<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Cookie; 

use Closure;

class APIAuth
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
        $response = $next($request);
        if(Cookie::has('auth_token') && !empty(Cookie::get('auth_token'))) {
            var_dump("pass"); 
            return $response;
        }
        //unset($_COOKIE['token']);
        var_dump('fail'); 
        return redirect('/')->with('status', 'Please login with the correct credentials!');
    }
}
