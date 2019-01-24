<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />

    <title>groceR</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{ asset('css/animate.min.css')}}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{ asset('css/paper-dashboard.css')}}" rel="stylesheet"/>


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
                <li class="active">
                    <a href="{{ action('ProfileController@profile') }}">
                        <i class="ti-user"></i>
                        <p>My Profile</p>
                    </a>
                </li>
                <li>
                    <a href="{{url("/") . '/department/All'}}">
                        <i class="ti-shopping-cart-full"></i>
                        <p>Products</p>
                    </a>
                </li>
                <li>
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
                        <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a></li>
                  </ul>
              </div>
          </div>
      </nav>
        <main class="py-4">
        @yield('content')
        </main>



                              {{--<footer class="footer">--}}
            {{--<div class="container-fluid">--}}
                {{--<nav class="pull-left">--}}
                    {{--<ul>--}}

                        {{--<li>--}}
                            {{--<a href="http://www.creative-tim.com">--}}
                                {{--Creative Tim--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="http://blog.creative-tim.com">--}}
                                {{--Blog--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        {{--<li>--}}
                            {{--<a href="http://www.creative-tim.com/license">--}}
                                {{--Licenses--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</nav>--}}
                {{--<div class="copyright pull-right">--}}
                    {{--&copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="http://www.creative-tim.com">Creative Tim</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</footer>--}}
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="{{action('APILoginController@logout')}}">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>

<!--   Core JS Files   -->
<script src="{{ asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js')}}" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{ asset('js/bootstrap-checkbox-radio.js')}}"></script>

<!--  Charts Plugin -->
<script src="{{ asset('js/chartist.min.js')}}"></script>

<!--  Notifications Plugin    -->
<script src="{{ asset('js/bootstrap-notify.js')}}"></script>

<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="{{ asset('js/paper-dashboard.js')}}"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{ asset('js/demo.js')}}"></script>

</html>

