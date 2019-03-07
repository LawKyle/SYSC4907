<?php

namespace App\Http\Controllers;

use App\APIConnect;
use App\DBObjects\GroceryList;
use App\DBObjects\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Enums\API; 

class GroceryListController extends Controller
{
    public function shoppingList() {
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $lists = self::getAllLists();
        return view('groceryLists', ['lists' => $lists]);
    }

    public static function getAllLists() {
        $groceryLists = APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), [], API::SHOP_LIST);
        if($groceryLists == "FAIL") return [];
        $lists = [];
        foreach($groceryLists as $list) {
            $products = [];
            $index = 0;
            $data = array(API::LIST_ID => $list[API::LIST_ID]);
            $checked = APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::SHOP_LIST);
            foreach($list['product'] as $product) {
                array_push($products, Product::createFromJSON($product, $checked[$index]['checked']));
                $index++;
            }
            $list = GroceryList::createFromJSON($list, $products);
            array_push($lists, $list);
        }
        return $lists;
    }

    public function addNewList() {
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $newListID = self::generateNewListID();
        $data = array(API::LIST_ID => $newListID, API::NEW_NAME => "Grocery List");
        var_dump(APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::SHOP_LIST));

        return back();
    }

    public function deleteList($list_id) {
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $data = array(API::LIST_ID => $list_id, API::FLAG => API::DELETE);
        var_dump(APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::SHOP_LIST));
        return back();
    }

    public function addProduct(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $id = $dataArray[API::LIST_ID];
        $product = $dataArray[API::PROD_ID];
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);

        $product = json_decode($product);
        foreach($product as $prod) {
            $data = array(API::LIST_ID => $id, 'product' => $prod);
            APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::SHOP_LIST);
        }
        return json_encode("pass");
    }

    public function rmProduct(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $id = $dataArray[API::LIST_ID];
        $product = $dataArray[API::PROD_ID];
        $check = "uncheck";
        if($dataArray['check']) $check = "check";
        $data = array(API::LIST_ID => $id, 'product' => $product, API::FLAG=>$check);

        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::SHOP_LIST);
        return json_encode("pass");
    }

    public function deleteProduct(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $id = $dataArray[API::LIST_ID];
        $product = $dataArray[API::PROD_ID];
        $data = array(API::LIST_ID => $id, 'product' => $product, API::FLAG=>API::REMOVE);

        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::SHOP_LIST);
        return json_encode("pass");
    }

    public function editName(Request $request) {
        $dataArray = json_decode($request->input('data'), true);

        $id = $dataArray[API::LIST_ID];
        $newName = $dataArray[API::NEW_NAME];

        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $data = array(API::LIST_ID => $id, API::NEW_NAME => $newName);
        APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::SHOP_LIST);
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
