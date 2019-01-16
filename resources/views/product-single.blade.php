@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="container">
        <h2>{{ $product->getName() }} </h2>
        <img src="{{ asset('img/carrot.png') }}" width=100 style="padding-bottom: 10px;;">                       
        <p>{{ $product->getDescription() }}</p>
        <p>{{ $product->getTag() }}</p>
        <h4>Ingredients</h4>
        @foreach ($product->getIngredients() as $ing)
            <p>{{ $ing }}</p>
        @endforeach
    </div>
@endsection

