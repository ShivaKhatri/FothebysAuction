<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ClientBidDataTable;
use App\DataTables\CommisionBidDatatable;
use App\DataTables\LimitCommissionBidDataTable;
use App\Model\Auction;
use App\Model\Commission_Bid;
use App\Model\Item;
use App\User;
use Carbon\Carbon;
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
    public function index(CommisionBidDatatable $datatable, ClientBidDataTable $cdatatable)//here the datatable is called and assigned to variable and rendered into the view
    {
        if(Auth::user()->Cstatus=="Admin")
        return $datatable->render('backend.comission_bid.index');
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
        if(Auth::user()->Cstatus=="Buyer"||Auth::user()->Cstatus=="Both")//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
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
        else//if the user isnt either of the above the they are redirected to home page--}}
            return redirect('/redirect');
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {//stores the commission bid data
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bid($id)
    {
        $auction=Item::find($id)->auction()->first();
        $item=Item::find($id);
//        dd($auction->id);
        if(Auth::user()->Cstatus=="Both")
            return view('backend.comission_bid.commisionBid')->with('auction',$auction)->with('item',$item)->with('layout','bothLayout');

        elseif(Auth::user()->Cstatus=="Buyer")
            return view('backend.comission_bid.commisionBid')->with('auction',$auction)->with('item',$item)->with('layout','sellerLayout');

        else
            return redirect('/redirect');


    }

    public function edit($id)
    {
        $commission=Commission_Bid::find($id);
        $auction=Commission_Bid::find($id)->auction()->first();
        $item=Commission_Bid::find($id)->item()->first();
//        dd($item);
        if(Auth::user()->Cstatus=="Both")
            return view('backend.comission_bid.editBid')->with('auction',$auction)->with('item',$item)->with('layout','bothLayout')->with('commission',$commission);

        elseif(Auth::user()->Cstatus=="Buyer")
            return view('backend.comission_bid.editBid')->with('auction',$auction)->with('item',$item)->with('layout','sellerLayout')->with('commission',$commission);

        else
            return redirect('/redirect');
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $commission=Commission_Bid::find($id);
        $commission->auction_id=$request->auction_id;
        $commission->open=$request->open;
        $commission->max=$request->max;
        $commission->item_id=$request->item_id;
        $commission->client_id=Auth::user()->id;
        $commission->save();
        return redirect('commission');
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function limit($id)
    {
        if(Auth::user()->Cstatus=="Admin"){
            $user=User::find($id);
            $sort = str_split($user->bank_sort_no, 2);
            return view('backend.comission_bid.limitComissionBid')->with('user',$user)->with('sort',$sort);}

        else
            return redirect('/redirect');
    }

    ///admin updates the users commission limit
    public function limitIndex(LimitCommissionBidDataTable $datatable)
    {
        if(Auth::user()->Cstatus=="Admin")
            return $datatable->render('backend.comission_bid.limitIndex');
        else
            return redirect('/redirect');
    }

    //updates the users biding limit, admin submits the new value and it is updated here
    public function updateLimit(Request $request, $id)
    {
        $detail=User::find($id);
        $detail->update([
            'bidLimit'=>$request->limit
        ]);
        return redirect('/limit/index');
    }
}
