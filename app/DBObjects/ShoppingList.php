<?php
namespace App\DBObjects;

class ShoppingList {
    private $id;
    private $products;

    function __construct($id, $products) {
        $this->id = $id;
        $this->products = $products; 
    }

    function getID() {
        return $this->id; 
    }

    function getProducts() {
        return $this->products; 
    }
}
