@extends('backend.'.$layout)
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('commission.create')}}">Commission bid able Auction</a>
        <span class="breadcrumb-item active">Commission Bid </span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Commission Bid on this item</h3>
                    </div>
                    <div class="card-body">
                        {!! Form::model($commission, [
                              'route' => ['commission.update', $commission->id],
                              'class' =>"form-horizontal form-label-left",
                              'method' => 'PUT',
                              'id' => 'sectionForm',
                              'enctype' => "multipart/form-data",
                          ])
                          !!}
                    <div class="card-body">
                        @php
                            $limit=\Illuminate\Support\Facades\Auth::user()->bidLimit;
                         if($item->frontImage){
                        $image='';
                        }
                        else
                         $image=$item->frontImage;
                        @endphp
                        <img class="card-img-top" src="{{asset("images/item/".$image)}}" alt="No Image Found">                              <br>
                        Auction Lot No: {{$auction->lotNumber}} <br>
                        Item Lot Reference No:  {{$item->lotReferenceNumber}}<br>
                        Piece Title:  {{$item->Piece_Title}}<br>
                        Artist: {{$item->artists}}<br>
                        Commission Bid Limit: {{$limit}}<br>
                        {{ Form::hidden('auction_id', $auction->id) }}
                        {{ Form::hidden('item_id', $item->id) }}
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Commission Bid<span class="required">*</span>
                            </label>
                            <div class="row"><label class="control-label col-md-6 col-sm-6 col-xs-12" >Open<span class="required">*</span>
                                </label><label class="control-label col-md-6 col-sm-6 col-xs-12" >Max<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::number('open',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::number('max',null, array('class' => 'form-control col-md-7 col-xs-12','max'=>$limit,'required'=>'')) }}
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-center">
                        <button type="submit" form="sectionForm" class="btn btn-primary"> Commission Bid</button>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
@endsection


