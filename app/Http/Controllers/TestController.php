<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item=1;
        $item_value=DB::table('detail_item_value');
        $item_value->where('item_id','=',1)->delete();

        $detail = Category::find(1)->detail()->get();
        foreach ($detail as $get) {
            $detailValue = Detail::find($get->id)->detailValue()->get();
//            $count = count($detailValue);
            foreach ($detailValue as $value) {

                if ($value->type == "text") {
                    if ($value->name == "null") {
                        $name = $get->name;
                        $item_value->insert(['item_id' => $item, 'detail_value_id' => $value->id, 'string' => $request->$name]);

                    } else {
                        $name = $get->name;

                        $item_value->insert(['item_id' => $item, 'detail_value_id' => $value->id, 'string' => $request->$name]);

                    }
                } elseif ($value->type == "number") {
                    if ($value->name == "null") {
                        $name = $get->name;
                        $item_value->insert(['item_id' => $item, 'detail_value_id' => $value->id, 'integer' => $request->$name]);

                    } else {
                        $name = $get->name;

                        $item_value->insert(['item_id' => $item, 'detail_value_id' => $value->id, 'integer' => $request->$name]);

                    }
                } elseif ($value->type == "date") {
                    if ($value->name == "null") {
                        $name = $get->name;
                        $item_value->insert(['item_id' => $item, 'detail_value_id' => $value->id, 'date' => $request->$name]);

                    } else {
                        $name = $get->name;

                        $item_value->insert(['item_id' => $item, 'detail_value_id' => $value->id, 'date' => $request->$name]);

                    }
                }
            }
//        $adValue=
        }
           dd($get->name);


        return view('backend/test');

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
        //
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
