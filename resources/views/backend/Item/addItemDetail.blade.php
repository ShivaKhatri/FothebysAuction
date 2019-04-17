@extends('backend.layout')
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <a class="breadcrumb-item" href="{{route('item.index')}}">Item</a>
        <span class="breadcrumb-item active"> Add Item Details</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Verification') }}</div>

                    <div class="card-body">
                        {!! Form::model($item, [
      'route' => ['item.update', $item->id],
      'class' =>"form-horizontal form-label-left",
      'method' => 'PUT',
      'id' => 'userForm',
      'enctype' => "multipart/form-data",
  ])
  !!}
                        @csrf
                        @if($image!=null)
                            <img class="card-img-top" src="{{asset('images/item/'.$image->image)}}" >
                        @endif
                        <div class="card-title">Piece Title: {{$item->Piece_Title}}</div>
                        <div class="card-title">Lot Reference Number: {{$item->lotReferenceNumber}}</div>
                        <div class="card-title">Artist(s): {{$item->artists}}</div>
                        @php
                            $from='';   $to='';
                                if($item->from<0){
                                $from=$item->from.'BC';
                                }
                                else{
                                $from=$item->from.'AD';

                                }
                                if($item->to<0){
                                         $to=$item->to.'BC';

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
                        <div class="card-title">Client: {{$client->FirstName}} {{$client->Surname}}</div>
                        {!! $html!!}
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Estimated Price<span class="required">*</span>
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                {{ Form::number('estimated_price_from',null, array('class' => 'form-control col-md-5 col-xs-12','required'=>'','style'=>'margin-right:10px')) }}
                                {{ Form::number('estimated_price_to',null, array('class' => 'form-control col-md-5 col-xs-12','required'=>'')) }}
                            </div>
                        </div>

                        <div class="form-group ">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Authenticity Established
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                <input type="radio" name="authenticated" value="yes"  />
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Yes
                                </label>

                                <input type="radio" name="authenticated" value="no"  checked/>
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >No
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Experts Name
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                {{ Form::text('expert_name',null, array('class' => 'form-control col-md-7 col-xs-12','required'=>'')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Image(s)<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input multiple="multiple" name="images[]" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Additional Notes
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea class="textarea form-control" placeholder="Place some text here" name="additionalNote"></textarea>
                            </div>
                        </div>

                        <div class="form-group">

                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Approve Item for Auction
                            </label>
                            <div class="col-md-8 col-sm-8 col-xs-12 row">
                                <input type="radio" name="approve" value="allowed"  />
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Approve
                                </label>

                                <input type="radio" name="approve" value="notAllowed" checked />
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" >Reject
                                </label>
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
