<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SearchController;

class DBManager extends Model
{
  /**
   *
   * Select data from $table in database and pass it to controller
   *
   * @return   $table rows
   *
   */
    public static function select($table, $view) {
      $dbRows = DB::table($table)->get();
      return self::dbRowToObject($view, $dbRows);
    }

    private static function dbRowToObject($view, $dbRows) {
        $dbObjects = [];
        foreach($dbRows as $dbRow) {
          array_push($dbObjects, $view::createFromDB($dbRow));
        }
        return $dbObjects;
    }

  /**
   *
   * Select row from $table with $id
   * @param $view the view requesting the object (LED, Driver or Board)
   *        $id id of requested object
   * @return   $object with $id
   *
   */
    public static function selectRowsId($table, $view, $id_col, $id) {
      $dbRows = DB::table($table)->where($id_col, $id)->get()->first(); 
      return self::dbRowToObject($view, $dbRows);
    }

   /**
   * Select unique values from $col with where condition
   * @param $view the view requesting the object (LED, Driver or Board)
   *        $col values to select frmo
   *        $whereName column to select $whereVal from
   *        $whereVal value from column
   * @return $objects values from $col with $whereVal from $whereName
   */
    public static function selectColumnWhere($table, $col, $whereName, $whereVal) {
      $queryString = "SELECT " . $col . " from " . $table;
      $queryString .= " WHERE " . $whereName . "='" . $whereVal . "'";

      $values = [];
      $rows = DB::select($queryString);
      foreach($rows as $item) {
          array_push($values, $item->ingredent_id); 
      }
        
      return $values;  
    }

    public static function selectProductIngredients($id) {
      /*$dbRows = []; 
      $ingredientIDs = self::selectColumnWhere("Product_Ingredent", "ingredent_id", "product_id", $id);
      foreach($ingredientIDs as $ingID) {
        $productRow =  DB::table("Product")->where("product_id", $ingID)->get();
        array_push($dbRows, $productRow); 
      }
      return self::dbRowToObject("App\DBObjects\Product", $dbRows); */
    }


}
