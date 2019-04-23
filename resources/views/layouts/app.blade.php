
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fothebys Auction| Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Scripts -->
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
@yield('headCss')


    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/carousel.css') }}" rel="stylesheet">

</head>

<body style="background-image: url({{asset('images/climpek.png')}})" >
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#"><img src="{{asset('images/logo.jpg')}}" class="nav-icon" height="60" width="150"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse row" id="navbarCollapse">
            <ul class="navbar-nav  d-flex justify-content-center col-md-8">
                <li class="nav-item ">
                    <a class="nav-link" href="{{route('welcome')}}">Home</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{route('buyer')}}">Buyer</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{route('seller')}}">Seller</a>
                </li>

                @auth
                    <li class="nav-item ">
                        <form  role="form" method="POST" action="{{route('logout')}}">
                            {{ csrf_field() }}
                            <button class="btn btn-primary btn-flat" type="submit">Log out</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item ">
                        <a class="nav-link" href="{{route('login')}}">Login</a>
                    </li>
                @endauth


            </ul>
            <form class="form-inline mt-2 mt-md-0 col-md-4" action="{{route('search.store')}}" id="search" method="post">
                @csrf
                <input name="search"  class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" form="search" type="submit">Search</button>
            </form>
        </div>
    </nav>
    </header>

    <main role="main">
        <div height="120" width="120">this</div>
        @yield('content')
</main>



<script src="{{ asset('js/jquery.min.js') }}" ></script>
<script src="{{ asset('js/popper.min.js') }}" ></script>
<script src="{{ asset('js/bootstrap.min.js') }}" ></script>
@yield('scripts')
</body>
</html>
