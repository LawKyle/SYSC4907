<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DBManager;
use App\DBObjects\Product;
use App\DBObjects\Ingredient;
use App\DBObjects\Restriction;
use App\Enums\Department;
use Illuminate\Support\Facades\Cookie; 

class ProductController extends Controller
{
  public function searchDepartment($dept){
    if(!Cookie::get('token')) return redirect("/");
    $products = self::getAllProducts(); 

    if($dept == Department::ALL) return view('main', ['products' => $products]); 

    $deptProducts = []; 
    foreach($products as $prod) {
        if($prod->getTag() == strToUpper($dept)) array_push($deptProducts, $prod);
    }

    return view('main', ['products' => $deptProducts]);
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
        return view('main', ['products' => $products]);
    }
    return view('main', ['products' => $searchProducts]);
  }

  private function containsProduct($listProducts, $product) {
    foreach($listProducts as $prod) {
        if($prod->getDescription() == $product->getDescription()) return true;  
    }
    return false; 
  }

  public function getTappedProducts(Request $request) {
       if(!Cookie::get('token')) return redirect("/"); 
       $tappedProductsArr = DBManager::postRequestToAPI(Cookie::get('token'), [], 'product/');
        $products = [];
        foreach($tappedProductsArr as $product) {
            $ingredients = [];
            foreach($product['ingredient'] as $ing) {
                $ingredient = $ing['name'];
                array_push($ingredients, $ingredient);
            }
            array_push($products, Product::createFromJSON($product, $ingredients));
        }
        return view('main', ['products' => $products]);
   }

   public function getProduct($id) {
       if(!Cookie::get('token')) return redirect("/");
       $data = array('nfc_id' => $id); 
       $productJSON = DBManager::postRequestToAPI(Cookie::get('token'), $data, 'product/');
       $ingredients = [];
       foreach($productJSON[0]['ingredient'] as $ing) {
            array_push($ingredients, $ing["name"]); 
        }
       $product = Product::createFromJSON($productJSON[0], $ingredients);
       //return $productJSON[0]; 
       return view('product-single', ['product' => $product]);
   }

   public static function getAllIng() {
        $ingredientsJSON = DBManager::postRequestToAPI(Cookie::get('token'), [], 'ingredientList/');
        $ingredients = [];
        foreach($ingredientsJSON as $ing) {
            array_push($ingredients, Ingredient::createFromJSON($ing));
        }
        return $ingredients; 
   }

   public function editProduct(Request $request) {
        //if(!Cookie::get('token')) return redirect("/"); 
        $data = [];
        $data['new_name'] = $request->input('new_name');
        $data['nfc_id'] = $request->input('nfc_id');
        $data['new_nfc_id'] = $request->input('new_nfc_id');
        $data['new_product_id'] = $request->input('new_product_id');
        $data['new_tags'] = strToLower($request->input('new_tags'));

        $data['new_ingredientId'] = implode(",", $request->input('new_ingredientId')); 
        DBManager::postRequestToAPI(Cookie::get('token'), $data, 'newProduct/');

        var_dump($data);
        var_dump(implode(",", $request->input('new_ingredientId'))); 
        return redirect(url('/') . "/product/" . $request->input('new_nfc_id')); 
   }
}
