<?php

namespace App\Http\Controllers;

use App\APIConnect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Enums\API; 

class APILoginController extends Controller
{
    public function login(Request $request) {
        $data = array(API::USERNAME => $request->username, API::PASSWORD => $request->password);
        $authorizationToken = APIConnect::postRequestToAPI(null, $data, API::LOGIN);
        $cookie = null;

        if($authorizationToken == 'FAIL') {
            setcookie(API::AUTH_TOKEN, '', time() - 60);
            return response("FAIL");
        }

        Cookie::queue(API::AUTH_TOKEN, $authorizationToken['token'], 60);
        return redirect("/tappedProducts");
    }

    public function logout() {
        setcookie(API::AUTH_TOKEN, '', time() - 60);
        return redirect(API::HOME);
    }
}
