<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DBManager;
use App\DBObjects\Product;
use App\Enums\Department;
use Illuminate\Support\Facades\Cookie; 

class SearchController extends Controller
{
    private $token = "deb358ae6cbc43f3ec2373d67c9f590f7bac0ae0"; //TODO remove this and get from user!!

    public function loginTest(Request $request) {
        $url = env('APP_API') . 'login/';
        $data = array('username' => $request->username, 'password' => $request->password);
        $authorizationToken = DBManager::postRequestToAPI(null, $data, 'login/');
        $cookie = null; 

        //$authorizationToken = json_decode($authorizationToken, true)['token'];
        if($authorizationToken == 'FAIL') {
            var_dump('here');
            setcookie('token', '', time() - 60);
            return response("FAIL");
        }

        Cookie::queue('token', $authorizationToken['token'], 60); 
        return response(DBManager::postRequestToAPI($this->token, [], 'shoppingList/'));

    }

  public function test()
  {
    //$products = DBManager::select("Product", "App\DBObjects\Product");
    //return view('main', ['products' => $products]);
    if(!Cookie::get('token')) return redirect("/"); 
     $products = self::getAllProducts();
    return view('main', ['products' => $products]);
  }

  public function searchDepartment($dept){
    //$products = DBManager::select("Product", "App\DBObjects\Product");
    //if($dept == Department::ALL) return view('main', ['products' => $products]);

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
    $products = DBManager::select("Product", "App\DBObjects\Product");

    $searchProducts = [];
    foreach($products as $product) {
        if(((stripos($product->getDescription(), $query)) !== false || (stripos($product->getName(), $query)) !== false) && !$this->containsProduct($searchProducts, $product)) {
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
    else return view('main', ['products' => $searchProducts]);
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
            $ingredients = $ingredients = self::getAllIngredients($product); 
            array_push($products, Product::createFromJSON($product, $ingredients)); 
        }

        return view('main', ['products' => $products]);
   }

   public function shoppingList(Request $request) {
       if(!Cookie::get('token')) return redirect("/");
        $shoppingLists = DBManager::postRequestToAPI(Cookie::get('token'), [], 'shoppingList/');
        
        $lists = []; 
        foreach($shoppingLists as $list) {
            $products = []; 
            foreach($list['product'] as $product) {
                $ingredients = self::getAllIngredients($product); 
                array_push($products, Product::createFromJSON($product, $ingredients)); 
            }
            array_push($lists, $products); 
        }

        return view('groceryLists', ['lists' => $lists]); 
   }

   public function getProduct($id) {
       if(!Cookie::get('token')) return redirect("/"); 
        $productsJSON = DBManager::postRequestToAPI(Cookie::get('token'), [], 'productList/'); 
        foreach($productsJSON as $product) {
            $ingredients = self::getAllIngredients($product); 
            $product = Product::createFromJSON($product, $ingredients);
            if($product->getID() == $id) return view('product-single', ['product' => $product]);
        }
   }

   private static function getAllProducts() {
        $productsJSON = DBManager::postRequestToAPI(Cookie::get('token'), [], 'productList/'); 
        $products = []; 
        foreach($productsJSON as $product) {
            $ingredients = self::getAllIngredients($product);              
            array_push($products, Product::createFromJSON($product, $ingredients)); 
        }
        return $products; 
   }

   private static function getAllIngredients($product) {
        $ingredients = [];
        foreach($product['ingredient'] as $id) {
            $data = array('ingredient_id' => $id);
            $ingredient = DBManager::postRequestToAPI(Cookie::get('token'), $data, 'ingredientList/');
            foreach($ingredient as $ing) {
                array_push($ingredients, $ing['name']);
            }
        }
        return array_unique($ingredients); 
   }
}
