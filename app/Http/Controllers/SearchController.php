<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DBManager;
use App\DBObjects\Product;
use App\Enums\Department; 

class SearchController extends Controller
{
  public function test()
  {
    $products = DBManager::select("Product", "App\DBObjects\Product");
    return view('main', ['products' => $products]);
  }

  public function searchDepartment($dept){
    $products = DBManager::select("Product", "App\DBObjects\Product");
    if($dept == Department::ALL) return view('main', ['products' => $products]);

    $deptProducts = []; 
    foreach($products as $prod) {
        if($prod->getTag() == strToLower($dept)) array_push($deptProducts, $prod); 
    }
    return view('main', ['products' => $deptProducts]);
  }

  public function searchBar(Request $request) {
    $query = $request->input('query'); 
    $products = DBManager::select("Product", "App\DBObjects\Product");

    $searchProducts = [];
    foreach($products as $product) {
        if((stripos($product->getDescription(), $query)) !== false && !$this->containsProduct($searchProducts, $product)) {
            array_push($searchProducts, $product);
        }
        foreach((array)$product->getIngredients() as $ing) {
            if((stripos($ing, $query)) !== false && !$this->containsProduct($searchProducts, $product)) {
                array_push($searchProducts, $product);
            }
        }
    }

    if(empty($searchProducts)) return view('main', ['products' => $products]);
    else return view('main', ['products' => $searchProducts]);
  }

  private function containsProduct($listProducts, $product) {
    foreach($listProducts as $prod) {
        if($prod->getDescription() == $product->getDescription()) return true;  
    }
    return false; 
  }
}
