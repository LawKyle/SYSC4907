<?php

namespace App\Http\Middleware;
use App\APIConnect;
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
        $data = array('username' => $request->username, 'password' => $request->password);
        $authorizationToken = APIConnect::postRequestToAPI(null, $data, 'login/');

        if($authorizationToken != 'FAIL') {
            Cookie::queue('auth_token', $authorizationToken['token'], 60);
            return $next($request);
        }
        setcookie('auth_token', '', time() - 60);
        return redirect('/')->with('status', 'Please login with the correct credentials!');
    }
}
