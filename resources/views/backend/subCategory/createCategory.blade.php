@extends('backend.layout')
@section('content')
    {{--<div class="row">--}}
    <!-- general form elements -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('subCategory.index')}}">Sub Category</a>
        <span class="breadcrumb-item active"> Create Sub Category</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Add New Sub Category</h3>
                    </div>
                    {!! Form::open(array('route'=>'subCategory.store', 'class' =>"form-horizontal form-label-left", 'method' => 'post', 'id'=>'sectionForm', 'enctype' => "multipart/form-data")) !!}
                    <div class="card-body">
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Category') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('category',$category,null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Category']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Sub Category Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('name',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <form>
                <textarea class="textarea form-control" placeholder="Description of this subcategory" name="description"
                          ></textarea>
                                </form>
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

