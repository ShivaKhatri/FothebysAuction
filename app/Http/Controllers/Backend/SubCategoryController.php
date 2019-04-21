<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubCategoryDatatable;
use App\Model\Category;
use App\Model\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(SubCategoryDatatable $dataTable)

    {
        if(Auth::user()->Cstatus=="Admin") {//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
            return $dataTable->render('backend.subCategory.indexCategory');
} else
            return redirect('/redirect');



    }


    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->Cstatus=="Admin") {//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
            $category=Category::all()->pluck('name','id');
            return view('backend.subCategory.createCategory')->with('category',$category);
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
        $category=new SubCategory();
        $category->name=$request->name;
        $category->category_id=$request->category;
        $category->description=$request->description;
        $category->admin_id=Auth::user()->id;
        $category->save();
        return redirect('subCategory');
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
            $subCategory=SubCategory::find($id);
            $category=Category::all()->pluck('name','id');
            return view('backend.subCategory.editCategory')->with('subCategory',$subCategory)->with('category',$category);
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
        $category=Category::find($id);
        $category->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'admin_id'=>Auth::user()->id,
            'category_id'=>$request->category

        ]);
        return redirect('subCategory');
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

        SubCategory::destroy($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = SubCategory::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

}



