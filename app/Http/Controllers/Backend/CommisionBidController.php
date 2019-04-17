<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ClientBidDataTable;
use App\DataTables\CommisionBidDatatable;
use App\Model\Auction;
use App\Model\Commission_Bid;
use App\Model\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommisionBidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommisionBidDatatable $datatable, ClientBidDataTable $cdatatable)
    {
        if(Auth::user()->Cstatus=="Admin")
        return $datatable->render('backend.comission_bid.indexComission');
        elseif(Auth::user()->Cstatus=="Buyer")
            return $cdatatable->render('backend.comission_bid.indexComission');
        else
        return redirect('/redirect');

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $array=[];
        $auction=Auction::all();
        $for=0;
        foreach ($auction as $get){
            $commiDate= date("Y-m-d", strtotime("+1 day"));
//            dd($get->date);

            if($get->date==$commiDate) {
//                    $queryItem=Item::query()->where('auction_id','=',$get->id)->get();
                    if ($for > 0) {
//                        $item=[$item,$queryItem];
                        $array = [$array, $get];
                    }
                        else{
//                            $item=[$queryItem];

                            $array = [$get];}

                $for=$for+1;


                }

        }
        if($for==0){
            $array=null;
            return view('backend.comission_bid.buyerComissionBid')->with('array',$array)->with('message',"No Commission Bid Available At The Moment");

        }
        else
            return view('backend.comission_bid.buyerComissionBid')->with('array',$array);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $commission=new Commission_Bid();
        $commission->auction_id=$request->auction_id;
        $commission->open=$request->open;
        $commission->max=$request->max;
        $commission->item_id=$request->item_id;
        $commission->client_id=Auth::user()->id;
        $commission->save();
        return redirect('commission');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bid($id)
    {
        $auction=Item::find($id)->auction()->first();
        $item=Item::find($id);
//        dd($auction->id);
        return view('backend.comission_bid.commisionBid')->with('auction',$auction)->with('item',$item);

    }

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
