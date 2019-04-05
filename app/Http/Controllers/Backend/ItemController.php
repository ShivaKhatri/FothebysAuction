<?php

namespace App\Http\Controllers\Backend;

use App\Model\Category;
use App\Model\Classification;
use App\Model\Detail;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
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


        $category=Category::all()->pluck('name','id');
        $classification=Classification::all();
        $expert=User::all()->where('Cstatus','=','Admin');
        return view('backend.Item.createItem')->with('category',$category)->with('classification',$classification)->with('expert',$expert);
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

//        dd($html);
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
    //for related select box
    public function ajax($id)
    {

        $detail = Category::find($id)->detail()->get();
//        $detailName='';
        $html='';

        foreach ($detail as $get){
            $html=$html. '<div   class="form-group row">
                            <label for="type" class="control-label col-md-9 col-sm-9 col-xs-12" >'.$get->name.'</label>';
//            dd($get->id);

            $detailValue=Detail::find($get->id)->detailValue()->get();
            $count=count($detailValue);
            $i=0;
//            dd($detailValue);
            foreach($detailValue as $value){
                $i=$i+1;
                $html=$html. '                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
 <label for="type" class="control-label col-md-6 col-sm-6 col-xs-12" >'.$value->name.'</label>
                                    <input name="'.$value->name.'"
                                           class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                           type = "'.$value->type.'"
                                    />
                                </div>';
                if($count==$i){
                    $html=$html. '</div>';
                }
            }
//            dd($count);
        }


//        dd($detail);
        return json_encode($html);
    }
}
