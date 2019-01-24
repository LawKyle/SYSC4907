@extends('layouts.products')

@section('content')
          <!-- Page Content -->
          <main class="py-4" >
              <h2>My Profile</h2><br>
                <div class="container" style="margin-left: 2em;">
                    <h4>My Restrictions</h4>
                    <div class="row content">
                        <div class="col-md">
                            <div class="card" style="width: 21rem;">
                                @foreach ($restrictions as $restrict)
                                    <div class="card-header">
                                        <i class="fas fa-exclamation-circle"></i> {{ $restrict->getName() }}
                                    </div>
                                    @if(!empty($restrict->getIngredients()))
                                        <ul class="list-group list-group-flush">
                                            @foreach ($restrict->getIngredients() as $ing)
                                                    <li class="list-group-item" >
                                                        {{ $ing }}
                                                        <span class="pull-right">
                                                            <button class="btn btn-primary-purple"><i class="far fa-trash-alt"></i></button>
                                                        </span>
                                                    </li>
                                            @endforeach
                                            <button class="btn btn-block">Add Ingredient</button>
                                        </ul>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
          </main>
@endsection
