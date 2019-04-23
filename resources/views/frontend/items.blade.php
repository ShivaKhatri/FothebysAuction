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
                        <img class="card-img-top" src="{{asset('images/item/'.$item->frontImage)}}" >

                        <div class="card-title">Piece Title: {{$item->Piece_Title}}</div>
                        <div class="card-title">Lot Reference Number: {{$item->lotReferenceNumber}}</div>
                        <div class="card-title">Artist(s): {{$item->artists}}</div>
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
                                  echo '<div class="card-title">Period: '.$from.' to '.$to.'</div>';
                               }
                           else{
                             echo '<div class="card-title">Produced Year: '.$from.'</div>';

                           }
                        @endphp
                        <div class="card-title">Reserve Price: {{$item->reservePrice}}</div>
                        <div class="card-title">Category: {{$category->name}}</div>
                        <div class="card-title">Provenance Details: <a href="{{asset('/images/item/'.$item->provenance_details)}}">Link for the Image</a></div>
                        @php
                            if(!($SubCategory==null)){
                                                   echo '<div class="card-title">Sub Category: '.$SubCategory->name.'</div>';
                            }
                        @endphp
                        <div class="card-title">Classification: {{$classification->name}}</div>
                        {!! $html!!}
                    </div>

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
@endsection