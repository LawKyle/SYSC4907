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
}
