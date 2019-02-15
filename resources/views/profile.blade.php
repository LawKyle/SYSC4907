@extends('layouts.products')

@section('content')
          <!-- Page Content -->
    <div class="container-fluid">
        <h2>My Profile</h2>
        <div class="row">
            <div class="col-md-3">
                My Restrictions 
            </div>
            <div class="col-md-8">
                <select class="form-control js-example-basic-multiple mb-2" multiple="multiple">
                    <option value="">name</option>
                </select>
            </div>
            <div class="col-md-1">
                <button onclick="" class="btn mb-2"><i class="ti-check"></i></button>
            </div>
        </div>
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
