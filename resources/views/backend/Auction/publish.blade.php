@extends('backend.layout')
@section('content')
    {{--<div class="row">--}}
    <!-- general form elements -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('auction.index')}}">Auction</a>
        <span class="breadcrumb-item active"> Publish Auction</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Add New Auction</h3>
                    </div>
                    {!! Form::model($auction, [
                                               'route' => ['auction.update', $auction->id],
                                               'class' =>"form-horizontal form-label-left",
                                               'method' => 'PUT',
                                               'id' => 'sectionForm',
                                               'enctype' => "multipart/form-data",
                                           ])
                                           !!}
                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-warning alert-dismissible ">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        @if($message)
                            <div class="alert alert-secondary alert-dismissible fade show">
                               {{$message}}
                            </div>
                        @endif
                        @if($auction->themeName=="Category")
                                <h6 class="card-title">There Are {{$count}} Items Assigned To This Auction </h6>
                                <h6 class="card-title">Theme: {{$auction->themeName}}-{{$auction->category()->first()->name}}</h6>
                                {{ Form::hidden('theme', $auction->themeName) }}
                                {{ Form::hidden('themeValue', $auction->themeValue) }}

                            @elseif($auction->themeName=="artists")
                                {{ Form::hidden('theme', $auction->themeName) }}
                                {{ Form::hidden('themeValue', $auction->themeValue) }}

                                <h6 class="card-title">Theme: Artist-{{$auction->themeValue}}</h6>
                            @endif

                            <h6 class="card-title">Date: {{$auction->date}}</h6>
                            {{ Form::hidden('date', $auction->date) }}

                            <h6 class="card-title">Location: {{$auction->location}}</h6>
                            {{ Form::hidden('location', $auction->location) }}
                            {{ Form::hidden('sessionAuction', $auction->session) }}

                        @if($auction->session==1)
                                    <h6 class="card-title">Session: First Session</h6>

                                @elseif($auction->session==2)
                                    <h6 class="card-title">Session: Second Session</h6>

                                @elseif($auction->session==3)
                                    <h6 class="card-title">Session: Third Session</h6>
                                @endif
                            <h6 class="card-title">Description: {{$auction->description}}</h6>
                            {{ Form::hidden('description', $auction->description) }}

                            <div class="form-group">
                            @if($html==null)
                                No Items Available To Assign
                                @else
                                    {!!                                $html!!}

                                @endif
                            </div>

                        <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Publish Auction
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                <input type="radio" name="status" value="1"  />
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Publish
                                </label>

                                <input type="radio" name="status" value="0" checked />
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Wait
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer justify-content-center">
                        <button type="submit" form="sectionForm" class="btn btn-success">Publish</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--</div>--}}

@endsection





