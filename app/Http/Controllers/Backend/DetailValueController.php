<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\DetailValueDatatable;
use App\Model\Detail;
use App\Model\Detail_value;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DetailValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DetailValueDatatable $datatable)
    {
        return $datatable->render('backend.DetailValue.indexDetailValue');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=Detail::all();
        return view('backend.DetailValue.createDetailValue')->with('category',$category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $detail=new Detail_value();
        $detail->name=$request->name;
        $detail->type=$request->type;
        $detail->description=$request->description;
        $detail->admin_id=Auth::user()->id;
        $detail->save();
        $ddv=DB::table('detail_detail_value');
        foreach($request->detail as $get)
        $ddv->insert([
            ['detail_id' => $get, 'detail_value_id' => $detail->id]
        ]);
        return redirect('detailValue');
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
        $detailValue=Detail_value::find($id);
        $detail=Detail::all();
        return view('backend.DetailValue.editDetailValue')->with('detailValue',$detailValue)->with('detail',$detail);

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
        $detail=Detail_value::find($id);
        $detail->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'admin_id'=>Auth::user()->id,
            'detail_id'=>$request->detail_id,
            'type'=>$request->type

        ]);
        $detail_value=DB::table('detail_detail_value');
        $detail_value->where('detail_value_id','=',$id)->delete();
        foreach($request->detail as $get)

            $detail_value->insert([
            ['detail_id' => $get, 'detail_value_id' => $detail->id]
        ]);
        return redirect('detailValue');
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

        Detail_value::destroy($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Detail_value::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
}
