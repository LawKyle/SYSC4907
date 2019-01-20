<?php

namespace App\Http\Controllers;

use App\DBManager;
use App\DBObjects\Restriction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ProfileController extends Controller
{
    public function profile() {
        if(!Cookie::get('token')) return redirect("/");
        $restrictionsJSON = DBManager::postRequestToAPI(Cookie::get('token'), [], 'restrictions/');

        $restrictions = [];
        foreach($restrictionsJSON as $restrict) {
            $ingredients = self::getAllIngredients2($restrict);
            array_push($restrictions, Restriction::createFromJSON($restrict, $ingredients));
        }
        return view('profile', ['restrictions' => $restrictions]);
    }
}
