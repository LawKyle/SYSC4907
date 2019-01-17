<?php
namespace App\DBObjects;
use App\DBManager;

class Ingredient {
    private $id;
    private $name;
    private $productID;

    public function __construct($id, $name, $productID) {
        $this->id = $id;
        $this->productID = $productID;
        $this->name = $name; 
    }

    public static function createFromJSON($ingredient) {
        return new Ingredient($ingredient['ingredient_id'], $ingredient['name'], 0); 
    }

    public function getID() {
        return $this->id; 
    }

    public function getProductID() {
        return $this->productID; 
    }

    public function getName() {
        return $this->name; 
    }
}
