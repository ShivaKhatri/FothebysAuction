@extends('backend.layout')
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('detail.index')}}">Detail</a>
        <span class="breadcrumb-item active">Edit Category Details</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Update User Details') }}</div>

                    <div class="card-body">
                        {!! Form::model($item, [
                              'route' => ['auctioned.update', $item->id],
                              'class' =>"form-horizontal form-label-left",
                              'method' => 'PUT',
                              'id' => 'sectionForm',
                              'enctype' => "multipart/form-data",
                          ])
                          !!}
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
                                    {{ Form::number('sold',$item->sold, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    {{ Form::number('sold_to_id',$item->sold_to_id, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
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
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" form="sectionForm"  class="btn btn-primary">
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

