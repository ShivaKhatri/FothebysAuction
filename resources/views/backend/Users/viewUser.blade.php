@extends('backend.'.$layout)
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('users.index')}}">Users</a>
        <span class="breadcrumb-item active">User Detail</span>
    </nav>
    <div class="row d-flex justify-content-center">

<div class="card col-lg-5 col-md-5 col-sm-5 col-xs-8">
    <div class="card-header">
       <h5 ><strong>{{$user->title}}  {{$user->FirstName}} {{$user->Surname}}</strong></h5>
    </div>
    <div class="card-body">
        <h5 class="card-title">Contact Details</h5>
        <p class="card-text">Email:{{$user->email}}</p>
        <p class="card-text">Telephone Number:{{$user->phone_no}}</p>
        <p class="card-text">Address:{{$user->address}}</p>
        @if($user->Cstatus!="Admin")
        <p class="card-text">Commission Bid Limit:{{$user->bidLimit}}</p>
        <h5 class="card-title">Bank Details </h5>
        <p class="card-text">
            Bank Account No: {{$user->bank_no}}<br>
            Bank Sort Code: {{$sort[0]}} - {{$sort[1]}} - {{$sort[2]}}
            </p>

        <div class="alert alert-success" role="alert">
            <h5 class="card-title">Verified By</h5>
            <p class="card-text">{{$verified_by->FirstName}} {{$verified_by->Surname}}</p>
        </div>
           @endif
        </div>
</div>
    </div>
    @endsection