@extends('layouts.app')
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <span class="breadcrumb-item active"> Show Item Details</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Item Details') }}</div>

                    <div class="card-body">

                        @php
                        $auction=$item->auction()->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12 row" ><div class="col-md-5 col-sm-4 col-xs-4">Auction Title: </div><div class="col-md-7 col-sm-8 col-xs-8">{{$auction->Auction_Title}}</div></div><div class="col-md-12 col-sm-12 col-xs-12"></div><hr class="col-md-11 col-sm-11 col-xs-11" style="background-color: #0b2e13">
                            <div class="col-md-12 col-sm-12 col-xs-12 row" > <div class="col-md-3 col-sm-3 col-xs-3">Location: </div><div class="col-md-3 col-sm-3 col-xs-3">{{$auction->location }}</div>
                            <div class="col-md-3 col-sm-3 col-xs-3">Auction Date: </div><div class="col-md-3 col-sm-3 col-xs-3">{{$auction->date }}</div></div><hr class="col-md-11 col-sm-11 col-xs-11" style="background-color: #0b2e13">
                            <div class="col-md-12 col-sm-12 col-xs-12 row" ><div class="col-md-4 col-sm-4 col-xs-4">Lot Reference Number: </div><div class="col-md-2 col-sm-2 col-xs-2">{{$item->lotReferenceNumber}}</div>
                            <div class="col-md-3 col-sm-3 col-xs-3">Auction Period: </div><div class="col-md-3 col-sm-3 col-xs-3">@if($auction->session==1) First Session @elseif($auction->session==2) Second Session @elseif($auction->session=3)Third Session @endif</div></div><hr class="col-md-11 col-sm-11 col-xs-11" style="background-color: #0b2e13">
                            <div class="col-md-3 col-sm-3 col-xs-3">Lot Number: </div><div class="col-md-8 col-sm-8 col-xs-8">{{$auction->lotNumber}}</div>
                        </div>
                        <div class="row">
                        @php
                                $from='';   $to='';
                                                   if($item->from<0){
                                                   $from=($item->from*-1).'BC';
                                                   }
                                                   else{
                                                   $from=$item->from.'AD';

                                                   }
                                                   if($item->to<0){
                                                            $to=($item->to*-1).'BC';

                                                   }
                                                   else{
                                                   $to=$item->to.'AD';
                                                   }
                                   if(!($item->to==null)){
                                      echo '<div class="card-title col-md-3 col-sm-3 col-xs-3">Period:</div><div class="col-md-8"> '.$from.' to '.$to.'</div>';
                                   }
                               else{
                                 echo '<div class="card-title col-md-3 col-sm-3 col-xs-3">Produced Year: </div><div class="col-md-8">'.$from.'</div>';

                               }
                        @endphp
                        </div><div class="row">
                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Piece Title: </div><div class="col-md-8 col-sm-8 col-xs-8">{{$item->Piece_Title}}</div>
                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Lot Reference Number: </div><div class="col-md-8 col-sm-8 col-xs-8">{{$item->lotReferenceNumber}}</div>
                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Artist(s):</div><div class="col-md-8 col-sm-8 col-xs-8"> {{$item->artists}}</div>
                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Reserve Price:</div><div class="col-md-8 col-sm-8 col-xs-8"> {{$item->reservePrice}}</div>
                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Category: </div><div class="col-md-8 col-sm-8 col-xs-8">{{$category->name}}</div>
                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Classification:</div><div class="col-md-8 col-sm-8 col-xs-8"> {{$classification->name}}</div>

                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Provenance Details:</div><div class="col-md-8 col-sm-8 col-xs-8"> {{$item->provenance_details}}</div>
                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Damage:</div><div class="col-md-8 col-sm-8 col-xs-8"> {{$item->damage}}</div>
                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Markings:</div><div class="col-md-8 col-sm-8 col-xs-8"> {{$item->markings}}</div>
                        @php
                            if(!($SubCategory==null)){
                                                   echo '<div class="card-title col-md-3 col-sm-3 col-xs-3">Sub Category:</div><div class="col-md-8 col-sm-8 col-xs-8"> '.$SubCategory->name.'</div>';
                            }
                        @endphp

                        <div class="card-title col-md-3 col-sm-3 col-xs-3">Classification:</div><div class="col-md-8 col-sm-8 col-xs-8"> {{$classification->name}}</div>
                        {!! $html!!}
                    </div>
                    <img class="card-img-bottom" src="{{asset('images/item/'.$item->frontImage)}}" >

                    @if($item->approved=="allowed")
                        <div class="alert alert-success card-footer" role="alert">
                            Verified
                        </div>

                    @elseif($item->approved=="notAllowed")
                        <div class="alert alert-danger card-footer" role="alert">
                            Rejected
                        </div>


                    @elseif($item->approved==null)
                        <div class="alert alert-primary card-footer" role="alert">
                            In Review
                        </div>


                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection