@extends('backend.layout')
@section('content')
    {{--<div class="row">--}}
    <!-- general form elements -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('category.index')}}">Category</a>
        <span class="breadcrumb-item active">Add Category Details</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Add New Detail</h3>
                    </div>
                    {!! Form::open(array('route'=>'detail.store', 'class' =>"form-horizontal form-label-left", 'method' => 'post', 'id'=>'sectionForm', 'enctype' => "multipart/form-data")) !!}

                    <div class="card-body">
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Category') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('category_id',$category,null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Category']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Detail Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('name',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Note
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <form>
                <textarea class="textarea form-control" placeholder="Place some text here" name="description"
                          ></textarea>
                                </form>
                            </div>
                        </div>
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Select Value Type') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('type',['text'=>'Text','number'=>'Number','date'=>'Date'],null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Input Value Type']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-5 col-sm-5 col-xs-12" >Enter the number of value fot this detail<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::number('number',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div id="additionalDetail">

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
            $('input[name="number"]').on('change', function() {
                var num = $(this).val();
                console.log(num);
                    $.ajax({
                        url: 'number/'+num,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {

                            console.log(data);

                            $('#additionalDetail').html(data);
                        }
                    });
            });
        });
    </script>
@endsection

