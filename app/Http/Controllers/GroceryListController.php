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
            $index = 0;
            $data = array('list_id' => $list['list_id']);
            $checked = APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'shoppingList/');
            foreach($list['product'] as $product) {
                $ingredients = self::getAllIngredients($product);
                array_push($products, Product::createFromJSON($product, $ingredients, $checked[$index]['checked']));
                $index++;
            }
            $list = GroceryList::createFromJSON($list, $products);
            array_push($lists, $list);
        }
        return $lists;
    }

    public function addNewList() {
        if(!Cookie::get('auth_token')) return redirect("/");
        $newListID = self::generateNewListID();
        $data = array('list_id' => $newListID, 'new_name' => "Grocery List");
        var_dump(APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'shoppingList/'));

        return back();
    }

    public function deleteList($list_id) {
        if(!Cookie::get('auth_token')) return redirect("/");
        $data = array('list_id' => $list_id, 'flag' => 'DELETE');
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

    public function rmProduct(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $id = $dataArray["list_id"];
        $product = $dataArray['product_id'];
        $check = "";
        if($dataArray['check']) $check = "check";
        else $check = "uncheck";
        $data = array('list_id' => $id, 'product' => $product, 'flag'=>$check);

        if(!Cookie::get('auth_token')) return redirect("/");
        APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'shoppingList/');
        return json_encode("pass");
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
