@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="row content">
        <div class="col">
        <h2>Products</h2>
            @foreach ($products as $product)
                <p>{{ $product->getName() }}</p>
                <p>{{ $product->getID() }}</p>
                <p>{{ $product->getNFCID() }}</p>
                <p>{{ $product->getDescription() }}</p>
                <p>{{ $product->getTag() }}</p>
                <h4>Ingredients</h4>
                @foreach ($product->getIngredients() as $ing)
                    <p>{{ $ing }}</p>
                @endforeach
                <hr>
            @endforeach
        </div>
    </div>
@endsection

