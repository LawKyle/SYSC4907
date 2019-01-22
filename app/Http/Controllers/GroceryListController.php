<?php

namespace App\Http\Controllers;

use App\APIConnect;
use App\DBObjects\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class GroceryListController extends Controller
{
    public function shoppingList(Request $request) {
        if(!Cookie::get('auth_token')) return redirect("/");
        $shoppingLists = APIConnect::postRequestToAPI(Cookie::get('auth_token'), [], 'shoppingList/');

        $lists = [];
        foreach($shoppingLists as $list) {
            $products = [];
            foreach($list['product'] as $product) {
                $ingredients = self::getAllIngredients($product);
                array_push($products, Product::createFromJSON($product, $ingredients));
            }
            array_push($lists, $products);
        }

        return view('groceryLists', ['lists' => $lists]);
    }

}
