<?php
namespace App\DBObjects;
use App\APIConnect;

class Ingredient {
    private $id;
    private $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name; 
    }

    public static function createFromJSON($ingredient) {
        return new Ingredient($ingredient['ingredient_id'], $ingredient['name']);
    }

    public function getID() {
        return $this->id; 
    }

    public function getName() {
        return $this->name;
    }
}
