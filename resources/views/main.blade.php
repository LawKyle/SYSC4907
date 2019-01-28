<?php
    use App\Enums\Department;
?>
@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="container-fluid">
        <h2>Products</h2>
        <?php $count = 0; ?>
        <div class="row content">
            @foreach ($products as $product) 
                @if($count != 0 && $count % 3 == 0)
                    </div>
                    <div class="row content">
                @endif
                    <div class="col-md-4">
                        @if($product->getImage() == null)
                            <img src="{{ asset('img/logo_groceR_small.jpg') }}" width=auto height="150" style="padding-bottom: 10px;">
                        @else
                            <img src="{{ $product->getImage() }}" width=auto height="150" style="padding-bottom: 10px;">
                        @endif

                        <p><a href="/product/{{ $product->getID() }}"> {{ $product->getName() }}</a></p>
                        {{--<p>{{ $product->getID() }}</p>--}}
                        {{--<p>{{ $product->getNFCID() }}</p>--}}
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

