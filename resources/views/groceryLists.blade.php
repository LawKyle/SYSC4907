@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="container-fluid" style="margin-left:50px">
        <h4> {{ $chosenList->getName() }}</h4>
        <div class="row content">
            <div class="col-md">
                <div class="card" style="width: 18rem;">
                    <ul class="list-group list-group-flush">
                        @foreach ($chosenList->getProducts() as $product)
                            <li class="list-group-item">{{ $product->getName() }}</li>
                        @endforeach
                        <button class="btn btn-primary btn-block">Add Product</button>
                    </ul>
                </div>
            </div>
        </div>
    </div>
 @endsection
