<?php
namespace App\DBObjects;
use App\DBManager;

class Restriction {
    private $name;
    private $ingredients; 

    public function __construct($name, $ingredients) {
        $this->name = $name;
        $this->ingredients = $ingredients;
    }

    public static function createFromJSON($restriction, $ingredients) {
        $name = $restriction['name'];
        return new Restriction($name, $ingredients);  
    }

    public function getName() {
        return $this->name; 
    }

    public function getIngredients() {
        return $this->ingredients; 
    }
}
