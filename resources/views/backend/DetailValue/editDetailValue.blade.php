@extends('backend.layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update User Details') }}</div>

                    <div class="card-body">
                        {!! Form::model($detailValue, [
      'route' => ['detailValue.update', $detailValue->id],
      'class' =>"form-horizontal form-label-left",
      'method' => 'PUT',
      'id' => 'userForm',
      'enctype' => "multipart/form-data",
  ])
  !!}
                        @csrf

                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Select Details') }}</label>

                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                @foreach($detail as $data)
                                    <div class="col-md-3 col-sm-3 col-xs-6">
                                        {{Form::checkbox('detail[]', $data->id,null,array('class'=>'flat-red'))}}&ensp;&ensp;
                                        <label>{{$data->name}}</label>
                                    </div>

                                @endforeach
                            </div>
                        </div>

                        <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >{{ __('Detail') }}</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::select('type',['text'=>'Text','number'=>'Number','date'=>'Date'],null,['class'=>'form-control','id'=>'title','required'=>'', 'placeholder'=>'Select Input Value Type']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Detail Value Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('name',$detailValue->name, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <form>
                <textarea class="textarea" placeholder="Place some text here" name="description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$detailValue->description}}</textarea>
                                </form>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" form="userForm" class="btn btn-primary">
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
