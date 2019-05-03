<?php

namespace App\Http\Controllers\Backend;

use App\Model\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = Item::where('Piece_Title', 'LIKE', '%' . $request->search . '%')->orWhere('artists', 'LIKE', '%' . $request->search . '%')->orWhere('lotReferenceNumber', 'LIKE', '%' . $request->search . '%')->get();

        $item=$item->where('approved','=', 'allowed');

//        dd($item);

        if ($request->has('itemName')) {
            $item->where('Piece_Title', 'LIKE', '%' . $request->itemName . '%');
        }
        if ($request->has('artistName')) {
            $item->where('artists', 'LIKE', '%' . $request->artistName . '%');
        }
        if ($request->from!=null) {
            $item->where('from', '<=',  $request->from);
        }
        if ($request->to!=null) {
            $item->where('to', '>=', $request->to);
        }
        if ($request->has('category')) {
            $item->where('category_id', '=',  $request->category);
        }
        if ($request->has('classification')) {
            $item->where('classification_id', '=',  $request->classification);
        }

//        dd($item);
        return view('frontend.search')->with('item',$item);

    }
    public function advance(Request $request)
    {
        $item = Item::query()->where('approved','=', 'allowed');

        if ($request->itemName!=null) {
            $item->where('Piece_Title', 'LIKE', '%' . $request->itemName . '%');
        }
        if ($request->artistName!=null) {
            $item->where('artists', 'LIKE', '%' . $request->artistName . '%');
        }
        if ($request->from!=null) {
            $item->where('from', '<=',  $request->from);
        }
        if ($request->to!=null) {
            $item->where('to', '>=', $request->to);
        }
        if ($request->category!=null) {
            $item->where('category_id', '=',  $request->category);
        }
        if ($request->classification!=null) {
            $item->where('classification_id', '=',  $request->classification);
        }

        if ($request->auction_date!=null) {
            $item->where('auction_date', '=',  $request->auction_date);
        }
        $item=$item->get();
//        dd($item);
        return view('frontend.search')->with('item',$item);

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
