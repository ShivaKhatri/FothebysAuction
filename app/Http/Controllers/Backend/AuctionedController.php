<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AuctionedDataTable;
use App\Model\Income;
use App\Model\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuctionedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuctionedDataTable $datatable)
    {
        if(Auth::user()->Cstatus=="Admin")//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
            return $datatable->render('backend.conductedAuction.indexAuction');
        else
            return redirect('/redirect');



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function auctioneer($id)
    {
        $Cstatus=Auth::user()->Cstatus;//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
        // When a user  tries to access this view the Cstatus of the user will  be checked
        if($Cstatus=="Admin") {
            $auction=Item::find($id)->auction()->first();
            $item = Item::find($id);
            return view('backend.conductedAuction.createAuction')->with('item', $item)->with('auction', $auction);
        }
        else
            return redirect('/redirect');


//        return redirect('auction/create')->with('message', 'The selected session is already assigned to auction lot: ');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->sold);
        $item=Item::find($request->item_id);
        $commission=$request->sold*(10/100);
        $income=new Income();
        $income->item_id=$request->item_id;
        $income->commission=$commission;
        $income->client_id=$item->client_id;
        $income->save();

             $item->update([

                 'sold'=>$request->sold,
                 'sold_to_id'=>$request->sold_to_id,
                 'auctioneer_comment'=>$request->auctioneer_comment
             ]);
        return redirect('auctioned');
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
    public function edit($id)
    {
        $Cstatus=Auth::user()->Cstatus;//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
        // When a user  tries to access this view the Cstatus of the user will  be checked
        if($Cstatus=="Admin") {
            $auction=Item::find($id)->auction()->first();
            $item = Item::find($id);
            return view('backend.conductedAuction.createAuction')->with('item', $item)->with('auction', $auction);
        }
        else
            return redirect('/redirect');


//        return redirect('auction/create')->with('message', 'The selected session is already assigned to auction lot: ');

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
        $item=Item::find($id);
        $income=$item->income()->first();
        $income=Income::find($income->id);
        $commission=$item->sold*(10/100);


        $income->update([

            'item_id'=>$request->item_id,
            'commission'=>$commission,
            'client_id'=>$item->client_id
        ]);
        $item->update([

            'sold'=>$request->sold,
            'sold_to_id'=>$request->sold_to_id,
            'auctioneer_comment'=>$request->auctioneer_comment
        ]);
        return redirect('auctioned');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
//        dd('here');
        if (!$this->checkId($id)) {
            return response()->json([
                'success' => 'Record not deleted!'
            ]);
        }
        $item_value=DB::table('detail_item_value');//assigns item value with detail item model
        $item_value->where('item_id','=',$id)->delete();//deletes the row whose item id matches with the $id
        Item::destroy($id);//deletes the item whose item matches the given id
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Item::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

}
