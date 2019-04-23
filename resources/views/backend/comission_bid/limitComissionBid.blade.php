@extends('backend.layout')
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('users.index')}}">Users</a>
        <span class="breadcrumb-item active">User Detail</span>
    </nav>
    <div class="row d-flex justify-content-center">

        <div class="card col-lg-4 col-md-4 col-sm-4 col-xs-8">
            <div class="card-header">
                <h5 ><strong>{{$user->title}}  {{$user->FirstName}} {{$user->Surname}}</strong></h5>
            </div>
            <div class="card-body">
                <h5 class="card-title">Contact Details</h5>
                <p class="card-text">Email:{{$user->email}}</p>
                <p class="card-text">Telephone Number:{{$user->phone_no}}</p>
                <p class="card-text">Address:{{$user->address}}</p>
                <h5 class="card-title">Bank Details </h5>
                <p class="card-text">
                    Bank Account No: {{$user->bank_no}}<br>
                    Bank Sort Code: {{$sort[0]}} - {{$sort[1]}} - {{$sort[2]}}
                </p>
                <div class="alert alert-warning" role="alert">
                    <h5 class="card-title">Previous Limit</h5>
                    <p class="card-text"><strong>{{$user->bidLimit}}</strong> </p>
                </div>

                {!! Form::model($user, [
              'route' => ['commission.updateLimit', $user->id],
              'class' =>"form-horizontal form-label-left",
              'method' => 'PUT',
              'id' => 'sectionForm',
              'enctype' => "multipart/form-data",
          ])
          !!}

                <div class="form-group">
                    <label class="control-label col-md-12 col-sm-12 col-xs-12" >New Commission Bid Limit<span class="required">*</span>
                    </label>
                    <div class="col-md-10 col-sm-10 col-xs-12">
                        {{ Form::number('limit',$user->bidLimit, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Change Limit') }}
                        </button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection