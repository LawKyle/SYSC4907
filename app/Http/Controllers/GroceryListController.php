<?php

namespace App\Http\Controllers;

use App\APIConnect;
use App\DBObjects\GroceryList;
use App\DBObjects\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class GroceryListController extends Controller
{
    public function shoppingList(Request $request) {
        $lists = self::getAllLists();
        return view('groceryLists', ['lists' => $lists, 'chosenList' => $lists[0]]);
    }

    public static function getAllLists() {
        if(!Cookie::get('auth_token')) return redirect("/");
        $groceryLists = APIConnect::postRequestToAPI(Cookie::get('auth_token'), [], 'shoppingList/');

        $lists = [];
        foreach($groceryLists as $list) {
            $products = [];
            foreach($list['product'] as $product) {
                $ingredients = self::getAllIngredients($product);
                array_push($products, Product::createFromJSON($product, $ingredients));
            }
            $list = GroceryList::createFromJSON($list, $products);
            array_push($lists, $list);
        }
        return $lists;
    }


    public function getList($id) {
        if(!Cookie::get('auth_token')) return redirect("/");
        $data = array('list_id' => $id);
        $groceryList = APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'shoppingList/');
        $products = [];
        foreach($groceryList['product'] as $product) {
            $ingredients = self::getAllIngredients($product);
            array_push($products, Product::createFromJSON($product, $ingredients));
        }
        $chosenList = GroceryList::createFromJSON($groceryList, $products);
        $lists = self::getAllLists();
        return view('groceryLists', ['lists' => $lists, 'chosenList' => $chosenList]);
    }

}
