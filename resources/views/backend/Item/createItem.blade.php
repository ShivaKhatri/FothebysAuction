@extends('backend.layout')
@section('content')
    {{--<div class="row">--}}
    <!-- general form elements -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Add New Item</h3>
                    </div>
                    {!! Form::open(array('route'=>'detailValue.store', 'class' =>"form-horizontal form-label-left", 'method' => 'post', 'id'=>'sectionForm', 'enctype' => "multipart/form-data")) !!}

                    <div class="card-body">
                        <div   id="additionalDetail">

                        </div>
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Category') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('category',$category,null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Input Value Type']) }}
                            </div>
                        </div>
                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Detail') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('type',['string'=>'Text','integer'=>'Number','date'=>'Date'],null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Input Value Type']) }}
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
                <textarea class="textarea" placeholder="Place some text here" name="description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
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
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('select[name="category"]').on('change', function() {
                var categoryId = $(this).val();
                console.log(categoryId);
                if(categoryId) {
                    $.ajax({
                        url: 'ajax/'+categoryId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {


                                $('#additionalDetail').html(data);
                        }
                    });
                }
            });
        });
    </script>
    @endsection

