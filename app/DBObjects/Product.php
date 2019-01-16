<?php
namespace App\DBObjects;
use App\DBManager;
use Ingredient; 

class Product {
    private $id;
    private $nfcID;
    private $description;
    private $name; 
    private $tag;
    private $ingredients; 

    public function __construct($id, $nfcID, $description, $name, $tag, $ingredients) {
        $this->id = $id;
        $this->nfcID = $nfcID;
        $this->description = $description;
        $this->name = $name; 
        $this->tag = $tag; 
        $this->ingredients = $ingredients; 
    }

    public static function createFromDB($product) {
        $ingredients = DBManager::selectProductIngredients($product->product_id);
        return new Product($product->product_id, $product->nfc_id, $product->description, $product->name, $product->tag, $ingredients); 
    }

    public static function createFromJSON($product) {
        $name = $product['name'];
        $nfcID = $product['nfc_id'];
        $productID = $product['product_id'];

        $desc = null;
        if(isset($product['description'])) $desc = $product['description'];

        $tag = null;
        if(isset($product['tags'])) $tag = $product['tags'];

        $ingredients = [];
        foreach($product['ingredient'] as $ing) {
            //$ingredient = new Ingredient($ing['ingredient_id'], $ing['name'], null);
            array_push($ingredients, $ing['name']); 
        }

        return new Product($productID, $nfcID, $desc, $name, $tag, $ingredients); 
    }

    public function getID() {
        return $this->id; 
    }

    public function getNFCID() {
        return $this->nfcID; 
    }

    public function getDescription() {
        return $this->description; 
    }

    public function getName() {
        return $this->name; 
    }

    public function getTag() {
        return $this->tag; 
    }

    public function getIngredients() {
        return $this->ingredients; 
    }

    public function isRestricted($ingredient) {
        return true; 
    }
}
