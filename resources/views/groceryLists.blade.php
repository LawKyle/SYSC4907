@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="row content">
        <div class="col">
            <h2>My Grocery Lists</h2>
            <?php $n = 1; ?>
            @foreach($lists as $list)
                <h4>List {{ $n }}</h4>
                @foreach ($list as $product)
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
                <?php $n++; ?>
            @endforeach
        </div>

    </div>
 @endsection
