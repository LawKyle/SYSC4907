<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DBManager;
use App\DBObjects\Product;
use App\DBObjects\Ingredient;
use App\DBObjects\Restriction;
use App\Enums\Department;
use Illuminate\Support\Facades\Cookie; 

class SearchController extends Controller
{
    const TOKEN = "deb358ae6cbc43f3ec2373d67c9f590f7bac0ae0"; //TODO remove this and get from user!!

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
        return response(DBManager::postRequestToAPI(self::TOKEN, [], 'shoppingList/'));

    }

  public function test()
  {
    //$products = DBManager::select("Product", "App\DBObjects\Product");
    //return view('main', ['products' => $products]);
    //if(!Cookie::get('token')) return redirect("/"); 
     $products = self::getAllProducts();
    return view('main', ['products' => $products]);
  }

  public function searchDepartment($dept){
    //$products = DBManager::select("Product", "App\DBObjects\Product");
    //if($dept == Department::ALL) return view('main', ['products' => $products]);

    //if(!Cookie::get('token')) return redirect("/"); 
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
       //if(!Cookie::get('token')) return redirect("/"); 
       $tappedProductsArr = DBManager::postRequestToAPI(self::TOKEN, [], 'product/'); 
        $products = []; 
        foreach($tappedProductsArr as $product) {
            $ingredients = self::getAllIngredients3($product); 
            array_push($products, Product::createFromJSON($product, $ingredients)); 
        }
        return view('main', ['products' => $products]);
   }

   public function shoppingList(Request $request) {
       //if(!Cookie::get('token')) return redirect("/");
        $shoppingLists = DBManager::postRequestToAPI(self::TOKEN, [], 'shoppingList/');
        
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
       //if(!Cookie::get('token')) return redirect("/");
       $data = array('nfc_id' => $id); 
       $productJSON = DBManager::postRequestToAPI(self::TOKEN, $data, 'product/');
       $ingredients = [];
       foreach($productJSON[0]['ingredient'] as $ing) {
            array_push($ingredients, $ing["name"]); 
        }
       $product = Product::createFromJSON($productJSON[0], $ingredients);
       //return $productJSON[0]; 
       return view('product-single', ['product' => $product]);
   }

   private static function getAllProducts() {
        $productsJSON = DBManager::postRequestToAPI(self::TOKEN, [], 'productList/'); 
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
            $ingredient = DBManager::postRequestToAPI(self::TOKEN, $data, 'ingredient/');
            array_push($ingredients, $ingredient[0]['name']);
        }
        return array_unique($ingredients); 
   }

   private static function getAllIngredients2($product) {
        $ingredients = [];
        foreach($product['ingredients'] as $id) {
            $data = array('ingredient_id' => $id);
            $ingredient = DBManager::postRequestToAPI(self::TOKEN, $data, 'ingredient/');
            array_push($ingredients, $ingredient[0]['name']);
        }
        return array_unique($ingredients); 
   }

      private static function getAllIngredients3($product) {
        $ingredients = [];
        foreach($product['ingredient'] as $ing) {
            $data = array('ingredient_id' => $ing['ingredient_id']);
            $ingredient = DBManager::postRequestToAPI(self::TOKEN, $data, 'ingredient/');
            array_push($ingredients, $ingredient[0]['name']);
        }
        return array_unique($ingredients); 
   }

   public static function getAllIng() {
        $ingredientsJSON = DBManager::postRequestToAPI(self::TOKEN, [], 'ingredientList/');
        $ingredients = [];
        foreach($ingredientsJSON as $ing) {
            array_push($ingredients, Ingredient::createFromJSON($ing));
        }
        return $ingredients; 
   }

   public function logout() {
       setcookie('token', '', time() - 60);
       return redirect("/"); 
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
        DBManager::postRequestToAPI($this->token, $data, 'newProduct/');

        var_dump($data);
        var_dump(implode(",", $request->input('new_ingredientId'))); 
        return redirect(url('/') . "/product/" . $request->input('new_nfc_id')); 
   }

   public function profile() {
        //if(!Cookie::get('token')) return redirect("/");
        $restrictionsJSON = DBManager::postRequestToAPI($this->token, [], 'restrictions/');

        $restrictions = []; 
        foreach($restrictionsJSON as $restrict) {
            $ingredients = self::getAllIngredients2($restrict);
            array_push($restrictions, Restriction::createFromJSON($restrict, $ingredients)); 
        }
        return view('profile', ['restrictions' => $restrictions]);
   }
}
