<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DBManager;
use App\DBObjects\Product;

class SearchController extends Controller
{
  public function test()
  {
    $products = DBManager::select("Product", "App\DBObjects\Product");
    return view('main', ['products' => $products]);
  }
}
