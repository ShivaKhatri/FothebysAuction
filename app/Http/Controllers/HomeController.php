<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $Cstatus=Auth::user()->Cstatus;
        if ($Cstatus=='Admin') {
            return view('backend/Users/admin')->with('Cstatus',$Cstatus);
        }
        elseif ($Cstatus=='Seller'){
            return view('backend/Users/seller')->with('Cstatus',$Cstatus);

        }
        elseif ($Cstatus=='Buyer'){
            return view('backend/Users/buyer')->with('Cstatus',$Cstatus);

        }
        elseif ($Cstatus=='Both'){
            return view('backend/Users/both')->with('Cstatus',$Cstatus);

        }
        else{
            return redirect('/');
        }
    }
}
