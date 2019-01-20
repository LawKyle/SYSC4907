<?php

namespace App\Http\Controllers;

use App\DBManager;
use App\DBObjects\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class GroceryListController extends Controller
{
    public function shoppingList(Request $request) {
        if(!Cookie::get('token')) return redirect("/");
        $shoppingLists = DBManager::postRequestToAPI(Cookie::get('token'), [], 'shoppingList/');

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
