<?php

namespace App\Http\Controllers;

use App\APIConnect;
use App\DBObjects\Restriction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends Controller
{
    public function profile() {
        if(!Cookie::get('auth_token')) return redirect("/");
        $restrictionsJSON = APIConnect::postRequestToAPI(Cookie::get('auth_token'), [], 'restrictions/');

        $restrictions = [];
        foreach($restrictionsJSON as $restrict) {
            $ingredients = self::getAllIngredients2($restrict);
            array_push($restrictions, Restriction::createFromJSON($restrict, $ingredients));
        }
        return view('profile', ['restrictions' => $restrictions]);
    }
}
