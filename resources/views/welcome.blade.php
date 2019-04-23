@extends('layouts.app')

@section('content')
    @php
        $item=\App\Model\Slider::all();
        $i=0;
        $j=0;
    @endphp
    <div id="myCarousel" class="carousel slide" data-ride="carousel" >
        <ol class="carousel-indicators">
            @foreach($item as $value)
                @if($i==0)
                    <li data-target="#myCarousel" data-slide-to="{{$i}}" class="active"></li>

                @else
                    <li data-target="#myCarousel" data-slide-to="{{$i}}" ></li>

                @endif

                @php
                    $i=$i+1;
                @endphp
            @endforeach

        </ol>
        <div class="carousel-inner">
            @foreach($item as $value)

                @if($j==0)
                    <div class="carousel-item active">
                        <img class="bd-placeholder-img" width="100%" height="100%" src="{{asset('images/slider/'.$value->image)}}" focusable="false" role="img">
                        <div class="container">
                            <div class="carousel-caption text-left">
                                <h1>{{$value->title}}</h1>
                                <p>{{$value->description}}</p>
                            </div>
                        </div>
                    </div>

                @else
                    <div class="carousel-item">
                        <img class="bd-placeholder-img" width="100%" height="100%" src="{{asset('images/slider/'.$value->image)}}" focusable="false" role="img">
                        <div class="container">
                            <div class="carousel-caption text-left">
                                <h1>{{$value->title}}</h1>
                                <p>{{$value->description}}</p>
                            </div>
                        </div>
                    </div>

                @endif

                @php
                    $j=$j+1;
                @endphp
            @endforeach

        </div>
        <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>


    <div class="container marketing">
    @php
        $getItem=\App\Model\Item::query()->limit(9)->where('approved','=','allowed')->get();
    @endphp
        <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center"><h1><strong>Featured Items</strong></h1></div>
            @foreach($getItem as $value)

                <div class="col-lg-4">
                    <img class="bd-placeholder-img" width="340" height="340" src="{{asset('images/slider/'.$value->frontImage)}}" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title>
                    <h2>{{$value->Piece_Title}}</h2>
                    <p>{{$value->description}}</p>
                    <p><a class="btn btn-secondary" href="{{route('item.frontShow',$value->id)}}" role="button">View details &raquo;</a></p>
                </div>


            @endforeach
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center"><a class="btn btn-secondary " href="#" role="button">View All &raquo;</a></div>
        </div><!-- /.row -->



        <!-- /END THE FEATURETTES -->

    </div><!-- /.container -->

@endsection
