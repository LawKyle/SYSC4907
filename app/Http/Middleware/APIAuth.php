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
        if(Cookie::has('token') && !empty(Cookie::get('token'))) {
            var_dump("pass"); 
            return redirect("/department/1/tappedProducts")->cookie('token', Cookie::get('token'), 60); 
        }
        //unset($_COOKIE['token']);
        var_dump('fail'); 
        return redirect('/')->with('status', 'Please login with the correct credentials!');
    }
}
