<?php

namespace App\Http\Controllers;

use App\APIConnect;
use App\DBObjects\GroceryList;
use App\DBObjects\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class GroceryListController extends Controller
{
    public function shoppingList() {
        if(!Cookie::get('auth_token')) return redirect("/");
        $lists = self::getAllLists();
        return view('groceryLists', ['lists' => $lists]);
    }

    public static function getAllLists() {
        $groceryLists = APIConnect::postRequestToAPI(Cookie::get('auth_token'), [], 'shoppingList/');
        if($groceryLists == "FAIL") return [];
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


//    public function getList($id) {
//        if(!Cookie::get('auth_token')) return redirect("/");
//        $data = array('list_id' => $id);
//        $groceryList = APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'shoppingList/');
//        $products = [];
//        foreach($groceryList['product'] as $product) {
//            $ingredients = self::getAllIngredients($product);
//            array_push($products, Product::createFromJSON($product, $ingredients));
//        }
//        $lists = self::getAllLists();
//        return view('groceryLists', ['lists' => $lists]);
//    }

    public function addNewList() {
        if(!Cookie::get('auth_token')) return redirect("/");
        $newListID = self::generateNewListID();
        $data = array('list_id' => $newListID, 'new_name' => "Grocery List");
        var_dump(APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'shoppingList/'));

        return back();
    }

    public function addProduct(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $id = $dataArray["list_id"];
        $product = $dataArray['product_id'];
        if(!Cookie::get('auth_token')) return redirect("/");

        $product = json_decode($product);
        foreach($product as $prod) {
            $data = array('list_id' => $id, 'product' => $prod);
            APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'shoppingList/');
        }
        return json_encode("pass");
    }

    public function rmProduct() {

    }

    public function editName(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $id = $dataArray["list_id"];
        $newName = $dataArray['new_name'];

        if(!Cookie::get('auth_token')) return redirect("/");
        $data = array('list_id' => $id, 'new_name' => $newName);
        APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'shoppingList/');
        return json_encode("pass");
    }

    private static function generateNewListID() {
        $lists = self::getAllLists();
        $listIDs = [];
        foreach($lists as $list) {
            array_push($listIDs, $list->getID());
        }
        $newListID = rand();
        while(in_array($newListID, $listIDs)) {
            $newListID = rand();
        }
        return $newListID;
    }

}
