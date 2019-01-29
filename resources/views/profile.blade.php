@extends('layouts.products')

@section('content')
          <!-- Page Content -->
    <div class="container-fluid">
        <h2>My Profile</h2>
        <h4>My Restrictions</h4>
        <div class="row">
            @foreach ($restrictions as $restrict)
                <div class="col-md-6">
                    <div class="card">
                        <div class="content table-responsive table-full-width">
                            <table class="table table-striped">
                                <thead style="background-color: #d1c4e9;">
                                    <th><i class="ti-na"></i> {{ $restrict->getName() }}</th>
                                </thead>
                                <tbody>
                                @if(!empty($restrict->getIngredients()))
                                        @foreach ($restrict->getIngredients() as $ing)
                                            <tr>
                                            <td>
                                                    {{ $ing->getName() }}
                                                    <span class="pull-right">
                                                        <button class="btn btn-primary-purple"><i class="ti-trash"></i></button>
                                                    </span>
                                            </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>
                                                <button class="btn btn-block">Add Ingredient</button>
                                            </td>
                                        </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
