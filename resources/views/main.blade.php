<?php
    use App\Enums\Department;
?>
@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="container">
        <h2>Products</h2>
        <?php $count = 0; ?>
        <div class="row content">
            @foreach ($products as $product) 
                @if($count != 0 && $count % 3 == 0)
                    </div>
                    <div class="row content">
                @endif
                    <div class="col-md-4">
                        <img src="{{ asset('img/carrot.png') }}" width=100 style="padding-bottom: 10px;;">
                        <p><a href="/product/{{ $product->getNFCID() }}"> {{ $product->getName() }}</a></p>
                        {{--<p>{{ $product->getID() }}</p>--}}
                        <p>{{ $product->getNFCID() }}</p>
                        {{--<p>{{ $product->getDescription() }}</p>--}}
                        {{--<p>{{ $product->getTag() }}</p>--}}
                        {{--<h4>Ingredients</h4>--}}
                        {{--@foreach ($product->getIngredients() as $ing)--}}
                            {{--<p>{{ $ing }}</p>--}}
                        {{--@endforeach --}}
                        <hr>
                    </div>
                    <?php $count++; ?>
            @endforeach
        </div>
    </div>
@endsection

