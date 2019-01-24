@extends('layouts.products')

@section('sidebar')
    <!-- Sidebar Departments -->
    <ul id="sidebar-dept" class="sidebar navbar-nav">
        @foreach($lists as $list)
            <li class="nav-item">
                <a class="nav-link" href="/list/{{ $list->getID() }}">{{ $list->getName() }}</a>
            </li>
        @endforeach
    </ul>
@endsection

@section('content')
    <!-- Page Content -->
    <div class="container">
        <h2>My Grocery Lists</h2>
        <div class="row content">
            <div class="col-md">
                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        {{ $chosenList->getName() }}
                    </div>
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
