@extends('backend.layout')
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('detail.index')}}">Detail</a>
        <span class="breadcrumb-item active">Edit Category Details</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update User Details') }}</div>

                    <div class="card-body">
                        {!! Form::model($detail, [
                              'route' => ['detail.update', $detail->id],
                              'class' =>"form-horizontal form-label-left",
                              'method' => 'PUT',
                              'id' => 'sectionForm',
                              'enctype' => "multipart/form-data",
                          ])
                          !!}
                        <div   class="form-group ">
                            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Category') }}</label>

                            <div class="col-md-6">
                                {{ Form::select('category_id',$category,$detail->category_id,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Category']) }}
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Detail Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('name',$detail->name, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group ">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea class="textarea form-control" placeholder="Place some text here" name="description">
                                    {{$detail->description}}
                                </textarea>
                            </div>
                        </div>
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Select Value Type') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('type',['text'=>'Text','number'=>'Number','date'=>'Date','radio'=>'Select One Type','checkbox'=>'Multiple'],null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Input Value Type']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Enter the number of value fot this detail<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::number('number',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div id="additionalDetail">

                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" form="sectionForm"  class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
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
