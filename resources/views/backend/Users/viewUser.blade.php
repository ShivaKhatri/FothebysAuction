@extends('backend.layout')
@section('content')

<div class="card col-lg-5 col-md-5 col-sm-5 col-xs-5">
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

        <h5 class="card-title">Verified By</h5>
        <p class="card-text">{{$verified_by->FirstName}} {{$verified_by->Surname}}</p>
    </div>
</div>
@if($user->Cstatus=='Buyer'||$user->Cstatus=='Both')
    <div class="card col-lg-9 col-md-9 col-sm-9 col-xs-9" style="margin-top: 10px">
        <div class="card-header">
            <h5 ><strong>Bought Items</strong></h5>
        </div>
        <div class="card-body">
            <table>
                <thead>

                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endif
@if($user->Cstatus=='Seller'||$user->Cstatus=='Both')
<div class="card col-lg-9 col-md-9 col-sm-9 col-xs-9" style="margin-top: 10px">
    <div class="card-header">
       <h5 ><strong>Sold Items</strong></h5>
    </div>
    <div class="card-body">
        <table>
            <thead>

            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endif
    @endsection