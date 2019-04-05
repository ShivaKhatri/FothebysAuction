@extends('backend.layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update User Details') }}</div>

                    <div class="card-body">
                        {!! Form::model($classification, [
                              'route' => ['classification.update', $classification->id],
                              'class' =>"form-horizontal form-label-left",
                              'method' => 'PUT',
                              'id' => 'sectionForm',
                              'enctype' => "multipart/form-data",
                          ])
                          !!}
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Classification Name<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::text('name',$classification->name, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <form>
                <textarea class="textarea" placeholder="Place some text here" name="description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$classification->description}}</textarea>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
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
