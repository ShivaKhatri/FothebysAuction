<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\pendingDatatable;
use App\DataTables\UnVerifiedDatatable;
use App\DataTables\UsersDatatable;
use App\DataTables\verifiedUsersDatatable;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
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
            return $user->render('backend.Users.indexUser');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.Users.registerUser');

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
        $user=User::find($id);
        $verified_by=User::find($user->verified_by);
        $sort = str_split($user->bank_sort_no,2);
        return view('backend.Users.viewUser')->with('user',$user)->with('verified_by',$verified_by)->with('sort',$sort);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);
        return view('backend.Users.editUser')->with('user',$user);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->checkId($id)) {
            return redirect()->route('users.index');
        }

        User::destroy($id);

        return redirect()->route('users.index');
    }

    public function checkId($id)
    {
        $query = User::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

    public function verified(verifiedUsersDatatable $verified){

        return $verified->render('backend.verifiedUsers.verifiedUsers');

    }
    public function unVerified(UnVerifiedDatatable $unverified){
        return $unverified->render('backend.unVerifiedUsers.unVerifiedUsers');

    }
    public function pending(pendingDatatable $user){

        return $user->render('backend.pendingUsers.pending');

    }
}
