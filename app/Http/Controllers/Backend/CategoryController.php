<?php

namespace App\Http\Controllers\Backend;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\DataTables\CategoryDatatable;
class CategoryController extends Controller
{
    protected $model;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        return view('backend.section.indexSection');
//    }

    public function index(CategoryDatatable $dataTable)

    {
        if(Auth::user()->Cstatus=="Admin")//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
        {
            return $dataTable->render('backend.Category.indexCategory');

        }
        else//if the user isnt either of the above the they are redirected to home page--}}
            return redirect('/redirect');



    }


    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Cstatus=Auth::user()->Cstatus;
        if($Cstatus=="Admin")
            return view('backend.Category.createCategory');
        else
            return redirect('/redirect');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category=new Category();
        $category->name=$request->name;
        $category->description=$request->description;
        $category->admin_id=Auth::user()->id;
        $category->save();
        return redirect('category');
    }

    /**
     * Display the specified resource.
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
        $Cstatus=Auth::user()->Cstatus;
        if($Cstatus=="Admin") {
            $category = Category::find($id);
            return view('backend.Category.editCategory')->with('category', $category);
        }
        else
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
//        dd($request->description);
        $category=Category::find($id);
        $category->update([
            'name'=>$request->name,
//            'updated_at'=>Carbon::now('asia/kathmandu'),
            'description'=>$request->description,
            'admin_id'=>Auth::user()->id

        ]);
        return redirect('category');
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
        $Cstatus=Auth::user()->Cstatus;
        if($Cstatus=="Admin") {
            if (!$this->checkId($id)) {
                return response()->json([
                    'success' => 'Record not deleted!'
                ]);
            }

            Category::destroy($id);
            return response()->json([
                'success' => 'Record deleted successfully!'
            ]);
        }
        else
            return redirect('/redirect');

    }

    public function checkId($id)
    {
        $query = Category::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

}



