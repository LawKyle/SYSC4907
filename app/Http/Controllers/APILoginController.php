<?php

namespace App\Http\Controllers;

use App\APIConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class APILoginController extends Controller
{
    public function login(Request $request) {
        $data = array('username' => $request->username, 'password' => $request->password);
        $authorizationToken = APIConnect::postRequestToAPI(null, $data, 'login/');
        $cookie = null;

        if($authorizationToken == 'FAIL') {
            var_dump('here');
            setcookie('auth_token', '', time() - 60);
            return response("FAIL");
        }

        Cookie::queue('auth_token', $authorizationToken['token'], 60);
        return redirect("/tappedProducts");
    }

    public function logout() {
        setcookie('auth_token', '', time() - 60);
        return redirect("/");
    }
}
