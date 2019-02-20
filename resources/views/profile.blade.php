@extends('layouts.products')
@section('content')
    <?php
        $tags = \App\Http\Controllers\ProfileController::getTags();
        $ingredients = \App\Http\Controllers\Controller::getAllIng();
    ?>
    <!-- Page Content -->
    <div class="container-fluid">
        <h2>My Profile</h2>
        <h3>My Restrictions</h3>
        <div class="row">
            <div class="col-md-5">
                @foreach ($tags as $tag)
                    <div class="col-md-6">
                    @if(in_array($tag, $restrictions))
                        <button id="{{ $tag }}" onclick="restriction(false, '{{ $tag }}');" class="btn btn-block">{{ $tag }}</button>
                    @else
                        <button id="{{ $tag }}" onclick="restriction(true, '{{ $tag }}');" class="btn btn-primary-purple btn-block">{{ $tag }}</button>
                    @endif
                    </div>
                @endforeach
            </div>
            @foreach ($customRestrictions as $restrict)
                <div class="col-md-6">
                    <div class="card">
                        <div class="content table-responsive table-full-width">
                            <table id="tableCustom" class="table table-striped">
                                <thead style="background-color: #d1c4e9;">
                                    <th><i class="ti-na"></i> {{ $restrict->getName() }}</th>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <select class="form-control js-example-basic-multiple mb-2" id="restrictions" name="restrictions[]" multiple="multiple">
                                                    @foreach($ingredients as $ing)
                                                        <option value="{{ $ing->getID() }}">{{ $ing->getName() }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                                <button onclick="addRestrictions()" class="btn mb-2"><i class="ti-check"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @if(!empty($restrict->getIngredients()))
                                    @foreach ($restrict->getIngredients() as $ing)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        {{ $ing->getName() }}
                                                    </div>
                                                    <div class="col-md-1">
                                                        <a href="/myProfile/rmRestrictions/{{ $ing->getID() }}" class='btn'><i class='ti-trash'></i></a>
                                                    </div>
                                                </div>
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
