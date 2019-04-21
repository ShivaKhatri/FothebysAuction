<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\DetailDatatable;
use App\Model\Category;
use App\Model\Detail;
use App\Model\Detail_value;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DetailDatatable $datatable)
    {
        if(Auth::user()->Cstatus=="Admin")//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
            return $datatable->render('backend.Detail.indexDetail');

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
        if(Auth::user()->Cstatus=="Admin") {//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
            $category = Category::all()->pluck('name', 'id');
            return view('backend.Detail.createDetail')->with('category', $category);
        } else
            return redirect('/redirect');



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detail=new Detail();
        $detail->name=$request->name;
        $detail->description=$request->description;
        $detail->category_id=$request->category_id;
        $detail->admin_id=Auth::user()->id;
        $detail->save();

        for ($i=0; $i<$request->number; $i++) {
            $value='Valuename'.$i;
//            dd($value);
            if($request->Valuename0=="null"){
                $detail_value = new Detail_value();
                $detail_value->name = 'null';
                $detail_value->detail_id = $detail->id;
                $detail_value->type = $request->type;
                $detail_value->admin_id = Auth::user()->id;
                $detail_value->save();
            }
            else{
                $detail_value = new Detail_value();
                $detail_value->name = $request->$value;
                $detail_value->detail_id = $detail->id;
                $detail_value->type = $request->type;
                $detail_value->admin_id = Auth::user()->id;
                $detail_value->save();
            }
        }
        return redirect('detail');
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
        if(Auth::user()->Cstatus=="Admin") {//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked

            $category=Category::all()->pluck('name','id');
            $detail=Detail::find($id);
            return view('backend.Detail.editDetail')->with('detail',$detail)->with('category',$category);
        } else
            return redirect('/redirect');

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
        $detail=Detail::find($id);
        $detail->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'admin_id'=>Auth::user()->id,
            'category_id'=>$request->category_id

        ]);
        $dValue=Detail::find($id)->detailValue()->get();
//        dd($request->number);

        foreach ($dValue as $get){
            Detail_value::destroy($get->id);
        }

        for ($i=0; $i<$request->number; $i++) {
            $value='Valuename'.$i;//for input names
//            dd($value);
            if($request->Valuename0=="null"){
                $detail_value = new Detail_value();
                $detail_value->name = 'null';
                $detail_value->detail_id = $id;
                $detail_value->type = $request->type;
                $detail_value->admin_id = Auth::user()->id;
                $detail_value->save();
            }
           else{
               $detail_value = new Detail_value();
               $detail_value->name = $request->$value;
               $detail_value->detail_id = $id;
               $detail_value->type = $request->type;
               $detail_value->admin_id = Auth::user()->id;
               $detail_value->save();
           }
        }
        return redirect('detail');
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

        $item_value=DB::table('detail_values');//assigns item value with detail item model
        $item_value->where('detail_id','=',$id)->delete();//deletes the row whose item id matches with the $id

        Detail::destroy($id);//deletes the item whose item matches the given id
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Detail::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

    public function number($id)
    {

        $html='';

//        for ($i=0; $i < $id; $i++){
//            $html=$html. ' this';
//            return json_encode($html);
//
//        }

        for ($i=0; $i<$id; $i++){
            if($id==1){

                    $html=$html. '
                       <input name="Valuename'.$i.'" type="hidden" value="null">
                        ';
            }
            else{
                $html=$html. '
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Detail Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="Valuename'.$i.'"
                                           class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                           type = "text"
                                           required=""
                                    />
                            </div>
                        </div>
                        ';
            }

        }
        return json_encode($html);

    }

    public function numberEdit($use,$id)
    {

        $html='';


        for ($i=0; $i<$id; $i++){
            if($id==1){

                $html=$html. '
                       <input name="Valuename'.$i.'" type="hidden" value="null">
                        ';
            }
            else{
                $html=$html. '
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" >Detail Name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input name="Valuename'.$i.'"
                                           class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                           type = "text"
                                           required=""
                                    />
                            </div>
                        </div>
                        ';
            }
        }
        return json_encode($html);

    }
}
