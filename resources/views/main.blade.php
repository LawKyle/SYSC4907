<?php
    use App\Enums\Department;
?>
@extends('layouts.products')

@section('content')
    <!-- Page Content -->
    <div class="container-fluid">
        @if(session()->has('status'))
            <div class="alert alert-warning }}">
                {{ session('status') }}
            </div>
        @endif
        <h2>{{ $title }}</h2>
        <?php $count = 0; ?>
            <div class="row content">
                @foreach ($products as $product)
                    @if($count != 0 && $count % 3 == 0)
                        </div>
                        <div class="row content">
                    @endif
                    <div class="col-md-4">
                        <a href="/product/{{ $product->getProductID() }}" class="product-link">
                            <div class="card">
                                <div class="content product-content">
                                    <img class="lazyload blur-up" src="{{ asset('tinyImg/' . $product->getPicture())}}" data-sizes="auto" data-src="{{ asset('img/' . $product->getPicture())}}" data-srcset="{{ asset('img/' . $product->getPicture())}}" style="padding-bottom: 10px;" height="150" width="auto">
                                    <div class="footer">
                                        <hr>
                                        {{ $product->getName() }}
                                    </div>
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

