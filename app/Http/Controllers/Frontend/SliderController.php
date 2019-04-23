<?php

namespace App\Http\Controllers\Frontend;

use App\DataTables\SliderDataTable;
use App\Model\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SliderDataTable $dataTable)
    {
        if(Auth::user()->Cstatus=="Admin")//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
        {
            return $dataTable->render('frontend.slider.index');

        }
        else//if the user isnt either of the above the they are redirected to home page--}}
            return redirect('/redirect');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->Cstatus=="Admin")//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
        {
            return view('frontend.slider.create');

        }
        else//if the user isnt either of the above the they are redirected to home page--}}
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
        $classification=new Slider();
        $classification->title=$request->title;
        $classification->description=$request->description;
        if (!file_exists(public_path() . '/images/slider/')) {
            mkdir(public_path() . '/images/slider/');
        }
        if ($request->image) {
            $file = $request->file('image');
            $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/slider/', $file_name);
//            dd($file_name);
            $classification->image = $file_name;
        }
        $classification->save();
        return redirect('slider');
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
        if(Auth::user()->Cstatus=="Admin")//{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
        {
            $classification=Slider::find($id);
            return view('frontend.slider.edit')->with('slider',$classification);
        }
        else//if the user isnt either of the above the they are redirected to home page--}}
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
        $classification=Slider::find($id);
        if (!file_exists(public_path() . '/images/slider/')) {
            mkdir(public_path() . '/images/slider/');
        }
        if ($request->image) {
            $file = $request->file('image');
            $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/slider/', $file_name);
//            dd($file_name);
            $cimage = $file_name;
        }
        $classification->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$cimage

        ]);
        return redirect('slider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('here');
        if (!$this->checkId($id)) {
            return response()->json([
                'success' => 'Record not deleted!'
            ]);
        }

        Slider::destroy($id);
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Slider::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

}
