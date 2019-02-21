<?php

namespace App\Http\Controllers;

use App\APIConnect;
use App\DBObjects\Restriction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Enums\API;

class ProfileController extends Controller
{
    public function profile() {
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $restrictionsJSON = APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), [], API::RESTRICTIONS);

        $customRestrictions = [];
        $restrictions = [];
        foreach($restrictionsJSON as $restrict) {
            $ingredients = self::getAllIngredients2($restrict);
            $restriction = Restriction::createFromJSON($restrict, $ingredients);
            if ($restrict[API::NAME] == "Custom") {
                array_push($customRestrictions, $restriction);
            }
            else {
                array_push($restrictions, $restrict[API::NAME]);
            }
        }
        return view('profile', ['customRestrictions' => $customRestrictions, 'restrictions' => $restrictions]);
    }

    public static function getTags() {
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $data = array(API::FLAG => API::TAGS);
        $restrictions = APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::RESTRICTIONS)[API::TAGS];
        return explode(", ", $restrictions);
    }

    public function addRestriction(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $restrict = $dataArray["ingredient"];
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $data = array(API::RESTRICT => $restrict);
        APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::RESTRICTIONS);
        return json_encode("pass");
    }

    public function rmRestriction(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $restrict = $dataArray["ingredient"];
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $data = array(API::RESTRICT => $restrict, API::FLAG => API::REMOVE);
        APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::RESTRICTIONS);
        return json_encode("pass");
    }

    public function addRestrictions(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $restriction = $dataArray["ingredient"];
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);

        $restrictions = json_decode($restriction);
        foreach($restrictions as $restrict) {
            $data = array(API::RESTRICT => $restrict);
            APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::RESTRICTIONS);
        }
        return json_encode("pass");
    }

    public function rmRestrictions($ingredient) {
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $data = array(API::RESTRICT => $ingredient, API::FLAG => API::REMOVE);
        APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::RESTRICTIONS);
        return back();
    }
}
