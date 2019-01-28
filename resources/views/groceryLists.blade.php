@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    {{--<div class="container-fluid" style="margin-left:50px">--}}
        {{--<h4> {{ $chosenList->getName() }}</h4>--}}
        {{--<div class="row content">--}}
            {{--<div class="col-md">--}}
                {{--<div class="card" style="width: 18rem;">--}}
                    {{--<ul class="list-group list-group-flush">--}}
                        {{--@foreach ($chosenList->getProducts() as $product)--}}
                            {{--<li class="list-group-item">{{ $product->getName() }}</li>--}}
                        {{--@endforeach--}}
                        {{--<button class="btn btn-primary btn-block">Add Product</button>--}}
                    {{--</ul>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <?php
        use App\Http\Controllers\Controller;
        $products = json_encode(Controller::getJSONProducts());
    ?>

    <div class="container-fluid">
        <h2>
            My Grocery Lists
            <a href="{{ action('GroceryListController@addNewList') }}" class="btn btn-primary-purple">Create New List </a>
        </h2>
        <?php $count = 0; ?>
        <div class="row">
        @foreach($lists as $list)
            @if($count != 0 && $count % 3 == 0)
            </div>
            <div class="row">
            @endif
                <div class="col-md-4">
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
                                    <th>Products<button class="btn pull-right" onclick="addProduct({{ $list->getID() }}, {{ $products }});"><i class="ti-plus"></i></button></th>

                                </thead>
                                <tbody>
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
 @endsection
