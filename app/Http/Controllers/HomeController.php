<?php
namespace App\Http\Controllers;

use App\DataTables\UpComingAuctionDataTable;
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
            return redirect('UpComingSellerAuction');

        }
        elseif ($Cstatus=='Buyer'){
            return redirect('UpComingBuyerAuction');

        }
        elseif ($Cstatus=='Both'){
            return redirect('UpComingBothAuction');

        }
        else{
            return redirect('UpComingGuestAuction');
        }
    }


    public function sellerAuction(UpComingAuctionDataTable $datatable)
    {
        return $datatable->render('backend/Users/seller');
    }
    public function buyerAuction(UpComingAuctionDataTable $dataTable)
    {
        return $dataTable->render('backend/Users/buyer');
    }
    public function bothAuction(UpComingAuctionDataTable $dataTable)
    {
        return $dataTable->render('backend/Users/both');
    }
    public function guestAuction(UpComingAuctionDataTable $dataTable)
    {
        return $dataTable->render('backend/Users/buyer');
    }

}
?>