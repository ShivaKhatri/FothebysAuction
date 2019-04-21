
@extends('backend.buyerLayout'){{--Backend layout for Admin(Fothebays staff--}}

@section('content')
    {{--<div class="row">--}}
    <!-- general form elements -->
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{route('home')}}">Home</a>
        <span class="breadcrumb-item active">Commission Bid</span>
    </nav>
    <div class="container">
        <div class="row justify-content-center">
            @php
            if($array==null){
              if($message){
              echo' <div class="col-md-12">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>'.$message.'!</strong>Please Check Back Later.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                        </div>';
              }



            }
            else{
                foreach($array as $get){

                      echo  '<div class="col-md-12">
                        <div class="card card-primary">
                        <div class="card-header with-border">
                            Auction Lot No:'.$get->lotNumber.'
                        </div>
                        <div class="row">';
                        $item=$get->item()->get();//assigning item variable with items this auction contains by using one to many relation of auction and item
                            foreach($item as $data){
                            $verifyId=\Illuminate\Support\Facades\Auth::user()->id;
                            if($data->bid()->get()->isEmpty()&&$data->bid()->where('client_id','!=',$verifyId)){//checks if the current item has been already bid by the user
                            $images=$data->image()->get();




            echo  ' <div class="card-body col-md-3 col-sm-3">
                        <div class="card card-primary">
                            <div class="card-header with-border">
                                Item Lot Reference No: '.$data->lotReferenceNumber.'
                            </div>
                            <div class="card-body">';
                                            foreach($images as $getImage){


                               echo  '  <img class="card-img-top" src="'.asset("images/item/".$getImage->image).'" alt="Card image cap">                              <br>
';

                }

                             echo  '    Piece Title: '.$data->Piece_Title.'<br>
                                Artist: '.$data->artists.'<br>';

                echo '   </div>
                <div class="card-footer"><a href="'.route('commission.bid',$data->id).'" class="btn btn-primary">Commission Bid</a></div>
                        </div>
                    </div>
                   ';}

                }
            }
            }
            @endphp
        </div>
    </div>
@endsection


