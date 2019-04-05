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
        if (Auth::user()->Cstatus=='Admin') {
            return view('backend/Users/admin');
        }
        elseif (Auth::user()->Cstatus=='Seller'){
            return view('backend/Users/seller');

        }
        elseif (Auth::user()->Cstatus=='Buyer'){
            return view('backend/Users/buyer');

        }
        elseif (Auth::user()->Cstatus=='Both'){
            return view('backend/Users/both');

        }
        else{
            return redirect('/');
        }
    }
}
