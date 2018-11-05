<?php
namespace App/DBObjects;

class Product {
    private $id;
    private $nfcID;
    private $description;
    private $tag;
    private $ingredients; 

    function __construct($id, $nfcID, $description, $tag, $ingredients) {
        $this->id = $id;
        $this->nfcID = $nfcID;
        $this->description = $description;
        $this->tag = $tag; 
        $this->ingredients = $ingredients; 
    }

    function getID() {
        return $this->id; 
    }

    function getNFCID() {
        return $this->nfcID; 
    }

    function getDescription() {
        return $this->description; 
    }

    function getIngredients() {
        return $this->ingredients; 
    }

    function isRestricted($ingredient) {
        return true; 
    }
}
