<?php
    use App\Enums\Department;
?>
@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="container-fluid">
        <h2>{{ $title }}</h2>
        <?php $count = 0; ?>
            <div class="row content">
                @foreach ($products as $product)
                    @if($count != 0 && $count % 3 == 0)
                        </div>
                        <div class="row content">
                    @endif

                        <div class="col-md-4">
                            <a href="/product/{{ $product->getID() }}" class="product-link">
                                <div class="card">
                                    <div class="content product-content">
                                        @if($product->getImage() == null)
                                            <img src="{{ asset('img/logo_groceR_small.jpg') }}" width=auto height="150" style="padding-bottom: 10px;">
                                        @else
                                            <img src="{{ asset('img/' . $product->getImage())}}" width=auto height="150" style="padding-bottom: 10px;">
                                        @endif

                                        <div class="footer">
                                            <hr>
                                            {{ $product->getName() }}
                                        </div>
                                        {{--<p>{{ $product->getID() }}</p>--}}
                                        {{--<p>{{ $product->getNFCID() }}</p>--}}
                                        {{--<p>{{ $product->getDescription() }}</p>--}}
                                        {{--<p>{{ $product->getTag() }}</p>--}}
                                        {{--<h4>Ingredients</h4>--}}
                                        {{--@foreach ($product->getIngredients() as $ing)--}}
                                            {{--<p>{{ $ing }}</p>--}}
                                        {{--@endforeach --}}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php $count++; ?>
                @endforeach
                        </div>
        </div>
    </div>
@endsection

