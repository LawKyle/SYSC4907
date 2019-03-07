<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\APIConnect;
use App\DBObjects\Product;
use App\DBObjects\Ingredient;
use App\Enums\Department;
use App\Enums\API; 
use Illuminate\Support\Facades\Cookie; 

class ProductController extends Controller
{
  public function searchDepartment($dept){
    if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
    $products = self::getAllProducts(); 

    if($dept == Department::ALL) return view('main', ['products' => $products, 'title' => $dept . " Products"]);

    $deptProducts = []; 
    foreach($products as $prod) {
        if($prod->getTags() == strToUpper($dept)) array_push($deptProducts, $prod);
    }

    return view('main', ['products' => $deptProducts, 'title' => $dept . " Products"]);
  }

  public function searchBar(Request $request) {
    $query = $request->input('query'); 
    $products = self::getAllProducts();

    $searchProducts = [];
    foreach($products as $product) {
        if(stripos($product->getName(), $query) !== false) {
            array_push($searchProducts, $product);
        }
        foreach((array)$product->getIngredients() as $ing) {
            if((stripos($ing->getName(), $query)) !== false) {
                array_push($searchProducts, $product);
            }
        }
    }

    if(empty($searchProducts)) {
        $request->session()->flash('status', "No products with '" . $query . "' found!");
        return view('main', ['products' => $products, 'title' => 'All Products']);
    }
  $request->session()->forget('status');
    return view('main', ['products' => $searchProducts, 'title' => "Search for '" . $query . "'"]);
  }

  public static function getTappedProducts() {
       if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
       $tappedProductsArr = APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), [], API::PROD);
       if(!isset($tappedProductsArr['TappedProducts']))  return view('main', ['products' => [], 'title' => 'Tapped Products']);
       else $tappedProductsArr = $tappedProductsArr["TappedProducts"];
       $products = [];
        foreach($tappedProductsArr as $product) {
            $ingredients = [];
            foreach($product['ingredient'] as $ing) {
                $ingredient = $ing['name'];
                array_push($ingredients, $ingredient);
            }
            array_push($products, Product::createFromJSON($product, null));
        }
        return view('main', ['products' => $products, 'title' => 'Tapped Products']);
   }

   public function getProduct($id, Request $request) {
       if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
       $data = array('product_id' => $id);
       $productJSON = APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::PROD);
       $ingredients = [];
       foreach($productJSON['product']['ingredient'] as $ing) {
           $ingredient = Ingredient::createFromJSON($ing);
           array_push($ingredients, $ingredient);
        }
       $product = Product::createFromJSON($productJSON['product'], "null");
       if(isset($productJSON[API::FLAG])) {
           $restrictions = explode(", ", $productJSON[API::FLAG]);
           $restrictions = implode(", ", array_unique($restrictions));
           $request->session()->flash('restriction', 'Warning: This product contains ' . $restrictions . "!");
           return view('product-single', ['product' => $product]);
       }
       $request->session()->forget('restriction');
       return view('product-single', ['product' => $product]);
   }

   public function editProduct(Request $request) {
        if(!Cookie::get(API::AUTH_TOKEN)) return redirect(API::HOME);
        $data = [];
        $data[API::NEW_NAME] = $request->input(API::NEW_NAME);
        $data[API::PROD_ID] = $request->input(API::PROD_ID);
        $data[API::NEW_PROD_ID] = $request->input(API::NEW_PROD_ID);
        $data[API::NEW_TAGS] = strToLower($request->input(API::NEW_TAGS));

        $data[API::NEW_ING] = implode(", ", $request->input(API::NEW_ING_ID));
        APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::NEW_PROD);

        var_dump($data);
        return redirect(url('/') . "/product/" . $request->input(API::NEW_PROD_ID));
   }

   public static function flagged($product_id) {
       $data = array('product_id' => $product_id);
       $productJSON = APIConnect::postRequestToAPI(Cookie::get(API::AUTH_TOKEN), $data, API::PROD);
       if(array_key_exists(API::FLAG, $productJSON)) return true;
       else return false;
    }

    public function checkFlagged(Request $request) {
        $dataArray = json_decode($request->input('data'), true);
        $product_id = $dataArray[API::PROD_ID];
        if(self::flagged($product_id)) return json_encode('red');
        else return json_encode('');

    }
}
