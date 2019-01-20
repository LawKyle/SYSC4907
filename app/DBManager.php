<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProductController;

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
   * @param $view the view requesting the object 
   *        $id id of requested object
   * @return   $object with $id
   *
   */
    public static function selectRowsId($table, $view, $id_col, $id) {
      $dbRows = DB::table($table)->where($id_col, $id)->get();
      return self::dbRowToObject($view, $dbRows);
    }

   /**
   * Select unique values from $col with where condition
   * @param $view the view requesting the object 
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
          array_push($values, $item->$col); 
      }
        
      return $values;  
    }

    public static function selectProductIngredients($id) {
      $dbRows = []; 
      $ingredientIDs = self::selectColumnWhere("Product_Ingredent", "ingredent_id", "product_id", $id);
      foreach($ingredientIDs as $ingID) {
        $ingredRow =  DB::table("Ingredent")->where("ingredent_id", $ingID)->get();
        array_push($dbRows, $ingredRow[0]->name); 
      }
      return $dbRows; 

    }

    public static function selectTappedProducts($id) {
      $products = []; 
      $productIDs = self::selectColumnWhere("Person_Product", "product_id", "user_id", 1);
      foreach($productIDs as $product_id) {
        $product = self::selectRowsId("Product", "App\DBObjects\Product", "product_id", $product_id);
       array_push($products, $product[0]);
      }
      return $products; 
    }

    public static function postRequestToAPI($token, $data, $path) {
        $header = "Content-type: application/x-www-form-urlencoded\r\n";
        if($token != null) {
             $header = "Authorization: token " . $token; 
        }

        $options = array(
            'http' => array(
                'header'  => $header,
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        
        $context  = stream_context_create($options);
        try {
            $result = @file_get_contents(env('APP_API') . $path, false, $context);
            if ($result === FALSE) {
               return 'FAIL'; 
            }
        }
        catch(Exception $e) {
            return view("welcome");  
        }

        return json_decode($result, true);
    }

    public static function getRequestToAPI($data, $path) {
        $header = "Content-type: application/x-www-form-urlencoded\r\n";

        $options = array(
            'http' => array(
                'header'  => $header,
                'method'  => 'GET',
                'content' => http_build_query($data)
            )
        );
        
        $context  = stream_context_create($options);
        try {
            $result = @file_get_contents(env('APP_API') . $path, false, $context);
            if ($result === FALSE) {
                var_dump("FAIL"); 
            }
        }
        catch(Exception $e) {
            return view("welcome");  
        }

        return json_decode($result, true);
    }


}
