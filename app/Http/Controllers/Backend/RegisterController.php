<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdminDatatable;
use App\DataTables\BothDatatable;
use App\DataTables\BuyerDatatable;
use App\DataTables\CustomerDatatable;
use App\DataTables\pendingDatatable;
use App\DataTables\SellersDatatable;
use App\DataTables\UnVerifiedDatatable;
use App\DataTables\UsersDatatable;
use App\DataTables\verifiedUsersDatatable;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDatatable $user)

    {
//        dd(Auth::user()->Cstatus);
        if(Auth::user()->Cstatus=="Admin")
            return $user->render('backend.Users.indexUser');
        else
            return redirect('/redirect');

    }


    public function buyer(BuyerDatatable $user)

    {
        if(Auth::user()->Cstatus=="Admin")
            return $user->render('backend.Users.indexUser');

        else
            return redirect('/redirect');

    }
    public function seller(SellersDatatable $user)

    {
        if(Auth::user()->Cstatus=="Admin")
            return $user->render('backend.Users.indexUser');


        else
            return redirect('/redirect');


    }
    public function both(BothDatatable $user)

    {
        if(Auth::user()->Cstatus=="Admin")
            return $user->render('backend.Users.indexUser');


        else
            return redirect('/redirect');


    }
    public function customer(CustomerDatatable $user)

    {
        if(Auth::user()->Cstatus=="Admin")
            return $user->render('backend.Users.indexUser');


        else
            return redirect('/redirect');


    }
    public function admin(AdminDatatable $user)

    {
        if(Auth::user()->Cstatus=="Admin")
            return $user->render('backend.Users.indexUser');


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
        if(Auth::user()->Cstatus=="Admin")
            return view('backend.Users.registerUser');


        else
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
        $this->validate($request,array(
            'FirstName'=>'required|max:15',
            'Surname'=>'required|max:15',
            'email'=>'required|email',
            'password'=>'required'
        ));
        $user=new User();
        $user->FirstName=$request->FirstName;
        $user->Surname=$request->Surname;
        $user->email=$request->email;
        $user->title=$request->title;
        $user->address=$request->address;
        $user->phone_no=$request->PhoneNo;
        if($request->type=="Buyer"||$request->type=="Seller"||$request->type=="Both"){
            $user->bank_no=$request->BankNo;
//            dd($request->BankSortNo1.$request->BankSortNo2.$request->BankSortNo3);
            $user->bank_sort_no=$request->BankSortNo1.$request->BankSortNo2.$request->BankSortNo3;
            $user->Astatus=$request->Astatus;

        }
        else{
            $user->Astatus="Admin";
        }
        $user->Cstatus=$request->type;
        if(Auth::user()){
            $user->added_by=Auth::user()->id;

            if($request->Astatus=='verified'||$request->Astatus=='UnVerified')
            $user->verified_by=Auth::user()->id;
        }
        $user->password=bcrypt($request->password);
        $user->save();
        return redirect('users');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            $user = User::find($id);
            $verified_by = User::find($user->verified_by);
            $sort = str_split($user->bank_sort_no, 2);
            if(Auth::user()->Cstatus=="Admin"){
                return view('backend.Users.viewUser')->with('user', $user)->with('verified_by', $verified_by)->with('sort', $sort)->with('layout', 'layout');

            }

                elseif(Auth::user()->Cstatus=="Seller"){
                    return view('backend.Users.viewUser')->with('user', $user)->with('verified_by', $verified_by)->with('sort', $sort)->with('layout', 'sellerLayout');

                }

                elseif(Auth::user()->Cstatus=="Buyer"){
                    return view('backend.Users.viewUser')->with('user', $user)->with('verified_by', $verified_by)->with('sort', $sort)->with('layout', 'buyerLayout');

                }

                elseif(Auth::user()->Cstatus=="Both"){
                    return view('backend.Users.viewUser')->with('user', $user)->with('verified_by', $verified_by)->with('sort', $sort)->with('layout', 'bothLayout');

                }

        else
            return redirect('/redirect');



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->Cstatus=="Admin"||Auth::user()->Cstatus=="Seller"||Auth::user()->Cstatus=="Buyer"||Auth::user()->Cstatus=="Both") {

            $user=User::find($id);
            return view('backend.Users.editUser')->with('user',$user);
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
        $this->validate($request,array(
            'FirstName'=>'required|max:15',
            'Surname'=>'required|max:15',
            'email'=>'required|email',
            'password'=>'required'
        ));
        $user=User::find($id);
        if(Auth::user()){
            $verified_by=null;
            if($request->Astatus=='verified'||$request->Astatus=='UnVerified')
                $verified_by=Auth::user()->id;
        }
        if($request->type=="Buyer"||$request->type=="Seller"||$request->type=="Both"){
            $user->update([
                'FirstName'=>$request->FirstName,
                'Surname'=>$request->Surname,
                'email'=>$request->email,
                'title'=>$request->title,
                'address'=>$request->address,
                'phone_no'=>$request->PhoneNo,
                'bank_no'=>$request->BankNo,
                'bank_sort_no'=>$request->BankSortNo1.$request->BankSortNo2.$request->BankSortNo3,
                'Astatus'=>$request->Astatus,
                'Cstatus'=>$request->type,
                'verified_by'=>$verified_by,
                'password'=>bcrypt($request->password)
            ]);
        }
        else{
            $user->update([
                'FirstName'=>$request->FirstName,
                'Surname'=>$request->Surname,
                'title'=>$request->title,
                'address'=>$request->address,
                'email'=>$request->email,
                'phone_no'=>$request->PhoneNo,
                'password'=>bcrypt($request->password),
                'bank_no'=>null,
                'bank_sort_no'=>null,
                'Astatus'=>"Admin",
                'Cstatus'=>$request->type
            ]);
        }

        return redirect('users');

    }
    public function verify($id)
    {

        if(Auth::user()->Cstatus=="Admin") {

            $user=User::find($id);
            $user->update([
                'Astatus'=>'verified',
                'verified_by'=>Auth::user()->id,
            ]);
                $name = $user->FirstName;
                $email = $user->email;

                $body =

                    "Dear " . $user->FirstName . ",
                        
                        We are pleased to inform you have been verified and registered to our system, now you can use our system with ease   
                        Mr M Fotherby
                        ";

                $data = array('name' => $name, "body" => $body);

                Mail::send('backend.mail.mail', $data, function ($message) use ($name, $email) {
                    $message->from('shivakhatri665@gmail.com', 'Shiva');

                    $message->to($email, $name)->subject('User Verification');
                });
            return redirect('users');
        }
        else
            return redirect('/redirect');



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->Cstatus=="Admin") {

            if (!$this->checkId($id)) {
                return redirect()->route('users.index');
            }

            User::destroy($id);

            return redirect()->route('users.index');
        }
        else
            return redirect('/redirect');

    }

    public function checkId($id)
    {
        $query = User::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

    public function verified(verifiedUsersDatatable $verified){

        if(Auth::user()->Cstatus=="Admin") {

            return $verified->render('backend.Users.indexUser');

        }
        else
            return redirect('/redirect');


    }
    public function unVerified(UnVerifiedDatatable $unverified){

        if(Auth::user()->Cstatus=="Admin") {

            return $unverified->render('backend.Users.indexUser');

        }
        else
            return redirect('/redirect');


    }
    public function pending(pendingDatatable $user){

        if(Auth::user()->Cstatus=="Admin") {

            return $user->render('backend.Users.indexUser');

        }
        else
            return redirect('/redirect');

    }
}
