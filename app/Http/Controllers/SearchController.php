<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DBManager;
use App\DBObjects\Product;
use App\Enums\Department; 

class SearchController extends Controller
{

    public function loginTest(Request $request) {
       /* $client = new \GuzzleHttp\Client();
        $URI = 'http://74.12.191.252:8000/login/'; 
       // $params['headers'] = ['Content-Type' => 'application/json', 'Authorization' => 'tokendeb358ae6cbc43f3ec2373d67c9f590f7bac0ae0', 'X-CSRF-TOKEN' => csrf_token() ];
        $params['form_params'] = array('username' => 'admin', 'password' => 'projectPass');
        $response = $client->post($URI, $params);
        var_dump($response->getBody());
        */

        $url = 'http://74.12.191.252:8000/login/';
        $data = array('username' => $request->username, 'password' => $request->password);

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        
            $context  = stream_context_create($options);
        try {
            $authorizationToken = @file_get_contents($url, false, $context);
            if ($authorizationToken === FALSE) {
               return view("welcome");  
            }
        }
        catch(Exception $e) {
            return view("welcome");  
        }

        var_dump($authorizationToken);


    }

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
      $products = DBManager::select("Product", "App\DBObjects\Product");

      //$userID = $request->input('userID');
      $userID = 1; 
      $tappedProducts = DBManager::selectTappedProducts($userID);
      if(empty($tappedProducts)) {
        $request->session()->flash('status', 'No tapped products found!');
        return view('main', ['products' => $products]);
      }
        else return view('main', ['products' => $tappedProducts]);
   }
}
