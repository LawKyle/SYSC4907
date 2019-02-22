<?php
namespace App\DBObjects;
use App\APIConnect;
use App\Enums\API;
use App\DBObjects\Ingredient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;

class Product {
    private $name;
    private $product_id;
    private $tags;
    private $ingredients;
    private $info;
    private $picture;
    private $checked;

    public function __construct($name, $product_id, $tags, $ingredients, $info, $picture, $checked) {
        $this->name = $name;
        $this->product_id = $product_id;
        $this->tags = $tags;
        $this->ingredients = $ingredients;
        $this->info = $info;
        $this->picture = $picture;
        $this->checked = $checked;
    }

    public static function createFromJSON($product, $checked) {
        $name = $product[API::NAME];
        $product_id = $product[API::PROD_ID];
        $tags = $product[API::TAGS];

        $info = null;
        if(isset($product[API::INFO])) $info = $product[API::INFO];

        $picture = null;
        if(isset($product[API::PICTURE])) $picture = $product[API::PICTURE];

        $ingredientsJSON = $product[API::INGREDIENT];
        $ingredients = [];
        foreach($ingredientsJSON as $ing) {
            array_push($ingredients, Ingredient::createFromJSON($ing));
        }

        return new Product($name, $product_id, $tags, $ingredients, $info, $picture, $checked);
    }

    public function getName() {
        return $this->name;
    }

    public function getProductID() {
        return $this->product_id;
    }

    public function getTags() {
        return $this->tags;
    }

    public function getIngredients() {
        return $this->ingredients; 
    }

    public function getInfo() {
        return $this->info;
    }

    public function getPicture() {
        if($this->picture != null && $this->picture != 'http://kltestserver.com/images/Mushroom- Button.png' && strpos($this->picture, 'png') == false) {
            $img = null;
            $filename = basename($this->picture);
            if(!file_exists(public_path('img/' . $filename))) {
                $img = Image::make($this->picture)->resize(null, 150, function ($constraint) {
                    $constraint->aspectRatio();
                });
             $img->save(public_path('img/' . $filename), 60);
            }
            if(!file_exists(public_path('tinyImg/' . $filename))) {
                $img = Image::make($this->picture)->resize(null, 10, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path('tinyImg/' . $filename), 60);
            }
            return $filename;
        }
        else {
            Image::make(public_path('img/logo_groceR_small.jpg'))->resize(null, 150, function ($constraint) {
                $constraint->aspectRatio();
            });
            if(!file_exists(public_path('tinyImg/logo_groceR_small.jpg'))) {
                $img = Image::make('img/logo_groceR_small.jpg')->resize(null, 10, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path('tinyImg/logo_groceR_small.jpg'), 60);
            }
            return 'logo_groceR_small.jpg';
        }
    }

    public function getChecked() {
        return $this->checked;
    }
}
