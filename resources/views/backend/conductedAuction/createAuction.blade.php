@extends('backend.layout')
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('auctioned.index')}}">Auctioned Items</a>
        <span class="breadcrumb-item active">Add Details</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-header with-border">
                        <h3 class="card-title">Add details of this item</h3>
                    </div>
                    {!! Form::open(array('route'=>'auctioned.store', 'class' =>"form-horizontal form-label-left", 'method' => 'post', 'id'=>'sectionForm', 'enctype' => "multipart/form-data")) !!}
                    <div class="card-body">
                        <img class="card-img-top" src="{{asset("images/item/".$item->frontImage)}}" alt="No Image Found">                              <br>
                        Auction Lot No: {{$auction->lotNumber}} <br>
                        Item Lot Reference No:  {{$item->lotReferenceNumber}}<br>
                        Piece Title:  {{$item->Piece_Title}}<br>
                        Artist: {{$item->artists}}<br>
                        {{ Form::hidden('item_id', $item->id) }}
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Commission Bid<span class="required">*</span>
                            </label>
                            <div class="row"><label class="control-label col-md-6 col-sm-6 col-xs-12" >Sold At<span class="required">*</span>
                                </label><label class="control-label col-md-6 col-sm-6 col-xs-12" >Buyers Client Number<span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::number('sold',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::number('sold_to_id',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Description
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea class="textarea form-control" placeholder="Place some text here" name="auctioneer_comment"
                          ></textarea>
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
@endsection


