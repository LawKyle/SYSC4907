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

        $customRestrictions = [];
        $restrictions = [];
        foreach($restrictionsJSON as $restrict) {
            $ingredients = self::getAllIngredients2($restrict);
            $restriction = Restriction::createFromJSON($restrict, $ingredients);
            if ($restrict['name'] == "Custom") {
                array_push($customRestrictions, $restriction);
            }
            else {
                array_push($restrictions, $restrict['name']);
            }
        }
        return view('profile', ['customRestrictions' => $customRestrictions, 'restrictions' => $restrictions]);
    }

    public static function getTags() {
        if(!Cookie::get('auth_token')) return redirect("/");
        $data = array('flag' => 'tags');
        $restrictions = APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'restrictions/')['tags'];
        return explode(", ", $restrictions);
    }

    public function addRestriction(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $restrict = $dataArray["ingredient"];
        if(!Cookie::get('auth_token')) return redirect("/");
        $data = array('restrict' => $restrict);
        APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'restrictions/');
        return json_encode("pass");
    }

    public function rmRestriction(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $restrict = $dataArray["ingredient"];
        if(!Cookie::get('auth_token')) return redirect("/");
        $data = array('restrict' => $restrict, 'flag' => 'remove');
        APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'restrictions/');
        return json_encode("pass");
    }

    public function addRestrictions(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $restriction = $dataArray["ingredient"];
        if(!Cookie::get('auth_token')) return redirect("/");

        $restrictions = json_decode($restriction);
        foreach($restrictions as $restrict) {
            $data = array('restrict' => $restrict);
            APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'restrictions/');
        }
        return json_encode("pass");
    }

    public function rmRestrictions(Request $request, $ingredient) {
        if(!Cookie::get('auth_token')) return redirect("/");
        $data = array('restrict' => $ingredient, 'flag' => 'remove');
        APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'restrictions/');
        return back();
    }
}
