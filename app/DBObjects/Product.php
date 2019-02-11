<?php
namespace App\DBObjects;
use App\APIConnect;
use Ingredient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManagerStatic as Image;

class Product {
    private $id;
    private $nfcID;
    private $description;
    private $name; 
    private $tag;
    private $ingredients;
    private $image;

    public function __construct($id, $nfcID, $description, $name, $tag, $ingredients, $image) {
        $this->id = $id;
        $this->nfcID = $nfcID;
        $this->description = $description;
        $this->name = $name; 
        $this->tag = $tag; 
        $this->ingredients = $ingredients;
        $this->image = $image;
    }

    public static function createFromDB($product) {
        $ingredients = APIConnect::selectProductIngredients($product->product_id);
        return new Product($product->product_id, $product->nfc_id, $product->description, $product->name, $product->tag, $ingredients, null);
    }

    public static function createFromJSON($product, $ingredients) {
        $name = $product['name'];
        $nfcID = null;
        if(isset($product['nfc_id'])) $nfcID = $product['nfc_id'];
        $productID = $product['product_id'];

        $desc = null;
        if(isset($product['description'])) $desc = $product['description'];

        $tag = null;
        if(isset($product['tags'])) $tag = $product['tags'];

        $image = null;
        if(isset($product['picture'])) $image = $product['picture'];

        return new Product($productID, $nfcID, $desc, $name, $tag, $ingredients, $image);
    }

    public function getID() {
        return $this->id; 
    }

    public function getNFCID() {
        return $this->nfcID; 
    }

    public function getDescription() {
        return $this->description; 
    }

    public function getName() {
        return $this->name; 
    }

    public function getTag() {
        return $this->tag; 
    }

    public function getIngredients() {
        return $this->ingredients; 
    }

    public function getImage() {
        if($this->image != null && $this->image != 'http://kltestserver.com/images/Mushroom- Button.png' && strpos($this->image, 'png') == false) {
            $img = null;
            $filename = basename($this->image);
            if(!file_exists(public_path('img/' . $filename))) {
                $img = Image::make($this->image)->resize(null, 150, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(public_path('img/' . $filename));
            }
            return $filename;
        }
        else {
            return null;
        }

    }
}
