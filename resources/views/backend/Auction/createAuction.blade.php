@extends('backend.layout')
@section('content')
    {{--<div class="row">--}}
    <!-- general form elements -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('auction.index')}}">Auction</a>
        <span class="breadcrumb-item active">Create Auction</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Add New Auction</h3>
                    </div>
                    {!! Form::open(array('route'=>'auction.store', 'class' =>"form-horizontal form-label-left", 'method' => 'post', 'id'=>'sectionForm', 'enctype' => "multipart/form-data")) !!}

                    <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-secondary alert-dismissible fade show">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Select Auction Theme') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('theme',['Category'=>'Category','artists'=>'Artist'],null,['class'=>'form-control','id'=>'theme','required'=>'', 'placeholder'=>'Select Theme']) }}
                            </div>
                        </div>
                        <div  id="additionalDetail">
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Note
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                <textarea class="textarea form-control" placeholder="Place some text here" name="description"
                          ></textarea>

                            </div>
                        </div>
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Select Session For The Auction') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('sessionAuction',['1'=>'1st Session','2'=>'2nd Session','3'=>'3rd Session'],null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Auction Session']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Location<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('location',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Auction Date<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::date('date',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                            <div class=" form-group row " id="items">
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
                        <button type="submit" form="sectionForm" class="btn btn-primary">Add</button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--</div>--}}

@endsection


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="theme"]').on('change', function() {
                var name = $(this).val();
                console.log(name);
                    $.ajax({
                        url: 'theme/'+name,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            // console.log(data);

                            $('#additionalDetail').html(data);
                        }
                    });
            });
        });
    </script>
    <script type="text/javascript">
        $(document).on('change', '.artists', function(){
            var categoryId = $(this).val();

            console.log(categoryId);
            if (categoryId) {
                $.ajax({
                    url: 'artists/' + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#items').html(data);


                    }

                });
            }
        });
        </script>
    <script type="text/javascript">
        $(document).on('change', '.category', function(){
            var categoryId = $(this).val();

            console.log(categoryId);
            if (categoryId) {
                $.ajax({
                    url: 'ajax/' + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        $('#items').html(data);


                    }

                });
            }
        });

    </script>
@endsection


