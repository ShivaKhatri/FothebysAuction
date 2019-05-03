@extends('layouts.app')

@section('content')
    <div class="container marketing">
    @php
        $getItem=\App\Model\Item::query()->limit(9)->where('approved','=','allowed')->get();
    @endphp
    <!-- Three columns of text below the carousel -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-center"><h1><strong>Featured Items</strong></h1></div>
            @foreach($getItem as $value)

                <div class="col-lg-4">
                    <img class="bd-placeholder-img" width="340" height="340" src="{{asset('images/item/'.$value->frontImage)}}" focusable="false" role="img" aria-label="Placeholder: 140x140"><title>Placeholder</title>
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
