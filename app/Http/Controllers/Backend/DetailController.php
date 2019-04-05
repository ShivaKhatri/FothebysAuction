<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\DetailDatatable;
use App\Model\Category;
use App\Model\Detail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DetailDatatable $datatable)
    {
        return $datatable->render('backend.Detail.indexDetail');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category=Category::all()->pluck('name','id');
        return view('backend.Detail.createDetail')->with('category',$category);

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
        $detail=Detail::find($id);
        return view('backend.Detail.editDetail')->with('detail',$detail);
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

        Detail::destroy($id);
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
}
