@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="container">
        <h2>My Grocery Lists</h2>
        <?php $count = 0; ?>
        <?php $n = 1; ?>
        <div class="row content">
            @foreach($lists as $list)
                @if($count != 0 && $count % 3 == 0)
                    </div>
                    <div class="row content">
                @endif
                <div class="col-md-4">
                    <h4>List {{ $n }}</h4>
                    @foreach ($list as $product)
                        <p>{{ $product->getName() }}</p>
                        <!--<p>{{ $product->getID() }}</p>
                        <p>{{ $product->getNFCID() }}</p>
                        <p>{{ $product->getDescription() }}</p>
                        <p>{{ $product->getTag() }}</p>
                        <h4>Ingredients</h4>
                        @foreach ($product->getIngredients() as $ing)
                            <p>{{ $ing }}</p>
                        @endforeach
                        <hr> -->
                    @endforeach
                    <?php $n++; ?>
                    <?php $count++; ?>
                </div>
            @endforeach
        </div>
    </div>
 @endsection
