<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\APIConnect;
use App\DBObjects\Product;
use App\DBObjects\Ingredient;
use App\DBObjects\Restriction;
use App\Enums\Department;
use Illuminate\Support\Facades\Cookie; 

class ProductController extends Controller
{
  public function searchDepartment($dept){
    if(!Cookie::get('auth_token')) return redirect("/");
    $products = self::getAllProducts(); 

    if($dept == Department::ALL) return view('main', ['products' => $products, 'title' => $dept . " Products"]);

    $deptProducts = []; 
    foreach($products as $prod) {
        if($prod->getTag() == strToUpper($dept)) array_push($deptProducts, $prod);
    }

    return view('main', ['products' => $deptProducts, 'title' => $dept . " Products"]);
  }

  public function searchBar(Request $request) {
    $query = $request->input('query'); 
    $products = self::getAllProducts();

    $searchProducts = [];
    foreach($products as $product) {
        if(((stripos($product->getDescription(), $query)) !== false || (stripos($product->getName(), $query)) !== false) ) {
            array_push($searchProducts, $product);
        }
        foreach((array)$product->getIngredients() as $ing) { 
            if((stripos($ing, $query)) !== false && !$this->containsProduct($searchProducts, $product)) {
                array_push($searchProducts, $product);
            }
        }
    }

    if(empty($searchProducts)) {
        $request->session()->flash('status', 'No products with ' . $query . ' found!');
        return view('main', ['products' => $products, 'title' => 'All Products']);
    }
    return view('main', ['products' => $searchProducts, 'title' => "Products"]);
  }

  private function containsProduct($listProducts, $product) {
    foreach($listProducts as $prod) {
        if($prod->getDescription() == $product->getDescription()) return true;  
    }
    return false; 
  }

  public static function getTappedProducts() {
       if(!Cookie::get('auth_token')) return redirect("/");
       $tappedProductsArr = APIConnect::postRequestToAPI(Cookie::get('auth_token'), [], 'product/');
       if(!isset($tappedProductsArr['TappedProducts']))  return view('main', ['products' => [], 'title' => 'Tapped Products']);
       else $tappedProductsArr = $tappedProductsArr["TappedProducts"];
       $products = [];
        foreach($tappedProductsArr as $product) {
            $ingredients = [];
            foreach($product['ingredient'] as $ing) {
                $ingredient = $ing['name'];
                array_push($ingredients, $ingredient);
            }
            array_push($products, Product::createFromJSON($product, $ingredients, null));
        }
        return view('main', ['products' => $products, 'title' => 'Tapped Products']);
   }

   public function getProduct($id, Request $request) {
       if(!Cookie::get('auth_token')) return redirect("/");
       $data = array('product_id' => $id);
       $productJSON = APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'product/');
       $ingredients = [];
       foreach($productJSON['product']['ingredient'] as $ing) {
           $ingredient = Ingredient::createFromJSON($ing);
           array_push($ingredients, $ingredient);
        }
       $product = Product::createFromJSON($productJSON['product'], $ingredients, "null");
       if(isset($productJSON['flag'])) {
           $request->session()->flash('restriction', 'Warning: This product contains ' . $productJSON['flag'] . "!");
       }
       return view('product-single', ['product' => $product]);
   }

   public function editProduct(Request $request) {
        //if(!Cookie::get('auth_token')) return redirect("/");
        $data = [];
        $data['new_name'] = $request->input('new_name');
        $data['nfc_id'] = $request->input('nfc_id');
        $data['new_nfc_id'] = $request->input('new_nfc_id');
        $data['new_product_id'] = $request->input('new_product_id');
        $data['new_tags'] = strToLower($request->input('new_tags'));

        $data['new_ingredientId'] = implode(",", $request->input('new_ingredientId')); 
        APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'newProduct/');

        var_dump($data);
        var_dump(implode(",", $request->input('new_ingredientId'))); 
        return redirect(url('/') . "/product/" . $request->input('new_nfc_id')); 
   }
}
