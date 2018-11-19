<?php
namespace App\DBObjects;
use App\DBManager;

class Product {
    private $id;
    private $nfcID;
    private $description;
    private $tag;
    private $ingredients; 

    public function __construct($id, $nfcID, $description, $tag, $ingredients) {
        $this->id = $id;
        $this->nfcID = $nfcID;
        $this->description = $description;
        $this->tag = $tag; 
        $this->ingredients = $ingredients; 
    }

    public static function createFromDB($product) {
        $ingredients = DBManager::selectProductIngredients($product->product_id);
        return new Product($product->product_id, $product->nfc_id, $product->description, $product->tag, $ingredients); 
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
