@extends('layouts.products')
<?php
    use App\Enums\Department;
    use App\Http\Controllers\SearchController;
    use App\DBObjects\Ingredient;
    $ingredients = SearchController::getAllIng();
?>
@section('content')
    <!-- Page Content -->
    <div class="container">
        <img src="{{ asset('img/carrot.png') }}" width=100 style="padding-bottom: 10px;">
        <h3>{{ $product->getName() }} </h3>
        <p>{{ $product->getDescription() }}</p>
        <p>Tag(s): {{ $product->getTag() }}</p>
        <h4>Ingredients</h4>
        @foreach ($product->getIngredients() as $ing)
            <p>{{ $ing }}</p>
        @endforeach
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary-purple" data-toggle="modal" data-target="#exampleModalCenter">
          Edit Product <i class="far fa-edit"></i>
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Edit {{ $product->getName() }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form method="post" action="{{ action('SearchController@editProduct') }}">
                  @csrf
                  <input type="hidden" class="form-control" name="nfc_id" value="{{ $product->getNFCID() }}">
                  <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="new_name" value="{{ $product->getName() }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="nfc_id" class="col-sm-3 col-form-label">NFC ID</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="new_nfc_id" value="{{ $product->getNFCID() }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="product_id" class="col-sm-3 col-form-label">Product ID</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" name="new_product_id" value="{{ $product->getID() }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="new_tags" class="col-sm-3 col-form-label">Tag</label>
                    <div class="col-sm-9">
                      <select class="custom-select" name="new_tags">
                          @foreach(Department::getTags() as $dept)
                               @if(strToUpper($dept) == strToUpper($product->getTag()))
                                  <option selected value="{{$dept}}">{{ $dept }}</option>  
                               @else
                                  <option value="{{$dept}}">{{ $dept }}</option>    
                               @endif
                          @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="new_ingredientId" class="col-sm-3 col-form-label">Ingredient</label>
                    <div class="col-sm-9">
                      <select class="custom-select" name="new_ingredientId[]" multiple>
                           @foreach($ingredients as $ing)
                               @if(in_array($ing->getName(), $product->getIngredients()))
                                  <option selected value="{{ $ing->getID() }}">{{ $ing->getName() }}</option>  
                               @else
                                  <option value="{{ $ing->getID() }}">{{ $ing->getName() }}</option>    
                               @endif
                          @endforeach                       
                        </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary-purple">Save changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
@endsection

