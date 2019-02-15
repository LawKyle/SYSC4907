@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <?php
        use App\Http\Controllers\Controller;
        //$products = json_encode(Controller::getJSONProducts());
        $products = Controller::getAllProducts();
    ?>

    <div class="container-fluid">
        <h2>
            My Grocery Lists
            <a href="{{ action('GroceryListController@addNewList') }}" class="btn btn-primary-purple">Create New List </a>
        </h2>
        <?php $count = 0; ?>
        <div class="row">
        @foreach($lists as $list)
            @if($count != 0 && $count % 2 == 0)
            </div>
            <div class="row">
            @endif
                <div class="col-md-6">
                    <div class="card">
                        <div style="background-color: #d1c4e9;padding-bottom:20px;" id="divList{{ $list->getID() }}" class="header">
                            <h4 id="title{{ $list->getID() }}" class="title">
                                {{ $list->getName() }}
                            </h4>
                            <button class="btn pull-right" onclick="deleteList({{$list->getID()}});"><i class="ti-trash"></i></button>
                            <button class="btn pull-right" onclick="editName({{$list->getID()}});"><i class="ti-pencil-alt"></i></button>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table id="table{{$list->getID()}}" class="table table-striped">
                                <thead>
                                    <th>Products
                                    </th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <select class="form-control js-example-basic-multiple mb-2" id="products{{ $list->getID() }}" name="products{{ $list->getID() }}[]" multiple="multiple">
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->getID() }}">{{ $product->getName() }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <button onclick="addProduct({{ $list->getID() }})" class="btn mb-2"><i class="ti-check"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach ($list->getProducts() as $product)
                                    <tr>
                                        <td><a href="/product/{{ $product->getID() }}">{{ $product->getName() }}</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php $count++; ?>
                @endforeach
            </div>
    </div>
 @endsection
