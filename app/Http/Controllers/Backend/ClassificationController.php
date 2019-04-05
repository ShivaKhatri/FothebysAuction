<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\ClassificationDatatable;
use App\Model\Classification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClassificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClassificationDatatable $dataTable)
    {
        return $dataTable->render('backend.Classification.indexClassification');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.Classification.createClassification');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $classification=new Classification();
        $classification->name=$request->name;
        $classification->description=$request->description;
        $classification->admin_id=Auth::user()->id;
        $classification->save();
        return redirect('classification');
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
        $classification=Classification::find($id);
        return view('backend.Classification.editClassification')->with('classification',$classification);
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
        $classification=Classification::find($id);
        $classification->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'admin_id'=>Auth::user()->id

        ]);
        return redirect('classification');
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

        Classification::destroy($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Classification::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }
}
