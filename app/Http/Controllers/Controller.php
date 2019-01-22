<?php

namespace App\Http\Controllers;

use App\APIConnect;
use App\DBObjects\Ingredient;
use App\DBObjects\Product;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Cookie;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected static function getAllProducts() {
        $productsJSON = APIConnect::postRequestToAPI(Cookie::get('auth_token'), [], 'productList/');
        $products = [];
        foreach($productsJSON as $product) {
            $ingredients = self::getAllIngredients($product);
            array_push($products, Product::createFromJSON($product, $ingredients));
        }
        return $products;
    }

    protected static function getAllIngredients($product) {
        $ingredients = [];
        foreach($product['ingredient'] as $id) {
            $data = array('ingredient_id' => $id);
            $ingredient = APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'ingredient/');
            array_push($ingredients, $ingredient[0]['name']);
        }
        return array_unique($ingredients);
    }

    protected static function getAllIngredients2($product) {
        $ingredients = [];
        foreach($product['ingredients'] as $id) {
            $data = array('ingredient_id' => $id);
            $ingredient = APIConnect::postRequestToAPI(Cookie::get('auth_token'), $data, 'ingredient/');
            array_push($ingredients, $ingredient[0]['name']);
        }
        return array_unique($ingredients);
    }

    public static function getAllIng() {
        $ingredientsJSON = APIConnect::postRequestToAPI(Cookie::get('auth_token'), [], 'ingredientList/');
        $ingredients = [];
        foreach($ingredientsJSON as $ing) {
            array_push($ingredients, Ingredient::createFromJSON($ing));
        }
        return $ingredients;
    }

}
