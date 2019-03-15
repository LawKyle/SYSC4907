@extends('layouts.products')
<?php
    use App\Enums\Department;
    use App\Http\Controllers\ProductController;
    use App\DBObjects\Ingredient;
    $ingredients = ProductController::getAllIng();
    $permission = App\Http\Controllers\Controller::getPermissions();
?>
@section('content')
    <!-- Page Content -->
    <div class="container-fluid">
        @if(session()->has('restriction'))
            <div class="alert alert-danger }}">
                {{ session('restriction') }}
            </div>
        @endif

            <img class="lazyload blur-up" src="{{ asset('tinyImg/' . $product->getPicture())}}" data-sizes="auto" data-src="{{ asset('img/' . $product->getPicture())}}" data-srcset="{{ asset('img/' . $product->getPicture())}}" style="padding-bottom: 10px;" height="150" width="auto">
        <h3>{{ $product->getName() }} </h3>
        <p>Tag(s): {{ $product->getTags() }}</p>
        {{--<p>Info: {{ $product->getInfo()}}</p>--}}
        <h4>Ingredients</h4>
        @foreach ($product->getIngredients() as $ing)
            <p>{{ $ing->getName() }} </p>

        @endforeach
        @if($permission != "customer")
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary-purple" data-toggle="modal" data-target="#exampleModalCenter">
              Edit Product <i class="ti-pencil-alt"></i>
            </button>
        @endif
    </div>
@endsection

@section('modal')
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
                    <form method="post" action="{{ action('ProductController@editProduct') }}">
                        @csrf
                        <input type="hidden" class="form-control" name="name" value="{{ $product->getName() }}">
                        <input type="hidden" class="form-control" name="product_id" value="{{ $product->getProductID() }}">
                        <input type="hidden" class="form-control" name="new_picture" value="{{ $product->getPicture() }}">

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="new_name" value="{{ $product->getName() }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="product_id" class="col-sm-3 col-form-label">Product ID</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="new_product_id" value="{{ $product->getProductID() }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_tags" class="col-sm-3 col-form-label">Tag</label>
                            <div class="col-sm-9">
                                <select class="form-control js-example-basic-multiple" style="width:100%;" name="new_tags">
                                    @foreach(Department::getTags() as $dept)
                                        @if(strToUpper($dept) == strToUpper($product->getTags()))
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
                                <select class="form-control js-example-basic-multiple" style="width:100%;" name="new_ingredientId[]" multiple>
                                    @foreach($ingredients as $ing)
                                        @if(in_array($ing, $product->getIngredients()))
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
@endsection

