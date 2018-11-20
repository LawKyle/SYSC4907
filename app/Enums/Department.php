<?php

namespace App\Enums;

class Department {
    const ALL = "All"; 
    const PRODUCE = "Produce";
    const MEAT = "Meat";
    const DAIRY = "Dairy";
    const BAKERY = "Bakery";
    const ORGANIC = "Organic";
    const DELI = "Deli";
    const SEAFOOD = "Seafood";
    const GROCERY = "Grocery"; 

    public static function getDepartments() {
        return [self::ALL, self::PRODUCE, self::MEAT, self::DAIRY, self::BAKERY, self::ORGANIC, self::DELI, self::SEAFOOD, self::GROCERY]; 
    }
}
