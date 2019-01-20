<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProductController;

class APIConnect extends Model
{
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
