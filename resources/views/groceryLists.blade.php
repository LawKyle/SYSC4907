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
    <div class="container-fluid">
        <h2>My Grocery Lists</h2>
        <?php $count = 0; ?>
        <div class="row">
        @foreach($lists as $list)
            @if($count != 0 && $count % 3 == 0)
            </div>
            <div class="row">
            @endif
                <div class="col-md-4">
                    <div class="card">
                        <div style="background-color: #d1c4e9;padding-bottom:20px;" class="header">
                            <h4 class="title">{{ $list->getName() }}</h4>
                        </div>
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead>
                                    <th>Products</th>
                                </thead>
                                <tbody>
                                @foreach ($list->getProducts() as $product)
                                    <tr>
                                        <td><a href="/product/{{ $product->getNFCID() }}">{{ $product->getName() }}</a></td>
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
