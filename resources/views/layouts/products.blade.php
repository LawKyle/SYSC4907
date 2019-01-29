<?php
    use App\Enums\Department;
    use App\Http\Controllers\GroceryListController;

    $lists = GroceryListController::getAllLists();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <title>groceR</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{ asset('css/animate.min.css')}}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ asset('css/paper-dashboard.css')}}" rel="stylesheet"/>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />


    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/themify-icons.css')}}" rel="stylesheet">

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="primary-purple">

        <!--
            Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
            Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
        -->

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="/department/All">
                    <img style="padding-left: 12px;" src="{{ asset('img/logo_groceR_crop.jpg') }}" width=120>
                </a>
            </div>

            <ul class="nav">
                <li class="{{ (\Request::route()->getName() == 'profile') ? 'active' : '' }}">
                    <a href="{{ action('ProfileController@profile') }}">
                        <i class="ti-user"></i>
                        <p>My Profile</p>
                    </a>
                </li>
                <li class="{{ (\Request::route()->getName() == 'department' || \Request::route()->getName() == 'tappedProducts') ? 'active' : '' }}">
                    {{--<a href="{{url("/") . '/department/All'}}">--}}
                        {{--<i class="ti-shopping-cart-full"></i>--}}
                        {{--<p>Products</p>--}}
                    {{--</a>--}}

                    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <i class="ti-shopping-cart-full"></i>
                        <p>Products</p>
                    </a>
                    <div class="collapse" id="collapseExample">
                        @foreach(Department::getDepartments() as $dept)
                            <a class="departments" href="/department/{{$dept}}"><p><i class="ti-arrow-circle-right"></i> {{ $dept }}</p></a>
                        @endforeach
                    </div>
                </li>
                <li class="{{ (\Request::route()->getName() == 'myGroceryList') ? 'active' : '' }}">
                    <a href="{{ action('GroceryListController@shoppingList') }}">
                        <i class="ti-view-list-alt"></i>
                        <p>My Grocery Lists</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <form class="form-inline" action="{{action('ProductController@searchBar')}}" method="GET">
                        @csrf
                        <div class="form-group mx-sm-3 mb-2">
                            <input name="query" type="text" class="form-control" placeholder="Search all products..." aria-label="Search" aria-describedby="basic-addon2">
                        </div>
                        <button class="btn btn-primary-purple" type="button">
                            <i class="ti-search"></i>
                        </button>
                    </form>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="{{action('APILoginController@logout')}}">Logout</a></li>
                  </ul>
              </div>
          </div>
      </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</div>

@yield('modal')

</body>

<!--   Core JS Files   -->
<script src="{{ asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js')}}" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{ asset('js/bootstrap-checkbox-radio.js')}}" async></script>

<!--  Charts Plugin -->
<script src="{{ asset('js/chartist.min.js')}}" async></script>

<!--  Notifications Plugin    -->
<script src="{{ asset('js/bootstrap-notify.js')}}" async></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

{{--Handle Grocery List Edits--}}
<script src="{{ asset('js/grocery-list.js') }}"></script>

</html>

