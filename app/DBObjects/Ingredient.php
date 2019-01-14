<?php
namespace App\DBObjects;
use App\DBManager;

class Product {
    private $id;
    private $name;
    private $productID

    public function __construct($id, $name, $productID) {
        $this->id = $id;
        $this->productID = $productID;
        $this->name = $name; 
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
