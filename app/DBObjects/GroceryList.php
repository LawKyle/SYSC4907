<?php
namespace App\DBObjects;
use App\APIConnect;

class GroceryList {
    private $id;
    private $name;
    private $products;

    public function __construct($id, $name, $products) {
        $this->id = $id;
        $this->name = $name;
        $this->products = $products;
    }

    public static function createFromJSON($list, $products) {
        $id = $list['list_id'];
        $name = $list['name'];
        return new GroceryList($id, $name, $products);
    }

    public function getID() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getProducts() {
        return $this->products;
    }
}
