<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{asset('bootstrap-4.1.3-dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <title>Grocery Web App</title>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-2">
          <div class="sidenav">
            <h3>Grocery Web App</h3>
            <a href="#">
              <div class="row">
                <div class="col text-center">
                  <i class="fas fa-user-circle fa-2x"></i>
                </div>
              </div>
              <div class="row">
                <div class="col text-center">
                  My Profile
                </div>
              </div>
            </a>
            <a href="#">
              <div class="row">
                <div class="col text-center">
                  <i class="fas fa-clipboard-list fa-2x"></i>
                </div>
              </div>
              <div class="row">
                <div class="col text-center">
                  My Grocery List
                </div>
              </div>
            </a>
            <a href="#">
              <div class="row">
                <div class="col text-center">
                  <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
              </div>
              <div class="row">
                <div class="col text-center">
                  Tagged Products
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="searchForm col-md">
          <div class="row">
              <div class="col">
                  <form class="form-inline" method="GET">
                      <input id="search" name="search" type="text" class="form-control" placeholder="Search for products ...">
                      <button id="searchBtn" type="submit" class="btn btn-outline-primary">Search</button>
                  </form>
              </div>
          </div>
          <div class="row">
            <div class="col">
                @foreach ($products as $product)
                    <p>{{ $product->getID() }}</p>
                    <p>{{ $product->getNFCID() }}</p>
                    <p>{{ $product->getDescription() }}</p>
                    <p>{{ $product->getTag() }}</p>

                    <hr>
                @endforeach
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.11/js/mdb.min.js"></script>
  </body>
</html>
