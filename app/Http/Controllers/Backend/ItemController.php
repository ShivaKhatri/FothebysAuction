<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\boughtDataTable;
use App\DataTables\InReviewDataTable;
use App\DataTables\ItemDataTable;
use App\DataTables\ItemUnVerifiedDataTable;
use App\DataTables\ItemVerifiedDataTable;
use App\DataTables\soldDataTable;
use App\Model\Category;
use App\Model\Classification;
use App\Model\Detail;
use App\Model\Image;
use App\Model\Income;
use App\Model\Item;
use App\Model\SubCategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ItemDataTable $item)//for view of all details of the items
    {
        if(Auth::user()->Cstatus=="Admin")///{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked
        return $item->render('backend.Item.indexItem');

        else
            return  redirect('/redirect');

    }
    public function verified(ItemVerifiedDataTable $item)//for the details of verified items
    {
        if(Auth::user()->Cstatus=="Admin")
            return $item->render('backend.Item.indexItem');

        else
            return  redirect('/redirect');

    }
    public function unVerified(ItemUnVerifiedDataTable $item)//renders the details of unverified items
    {
        if(Auth::user()->Cstatus=="Admin")///{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
            // When a user  tries to access this view the Cstatus of the user will  be checked

            return $item->render('backend.Item.indexItem');

    else
        return  redirect('/redirect');
    }
    public function inReview(InReviewDataTable $item)//renders the details of items in review
    {
        if(Auth::user()->Cstatus=="Admin")
            return $item->render('backend.Item.indexItem');

        else
            return  redirect('/redirect');
    }
    public function bought(boughtDataTable $item)//renders the details of item bought by the user
    {
            if (Auth::user()->Cstatus == "Buyer"){
                return $item->render('backend.Item.buyerItem');
            }
            elseif(Auth::user()->Cstatus == "Both"){
                return $item->render('backend.Item.bothItem');

            }

        else
            return  redirect('/redirect');

    }
    public function sold(soldDataTable $item)//renders the details of the item sold by the user
    {
            if (Auth::user()->Cstatus == "Seller"){
                return $item->render('backend.Item.sellerItem');

            }
            elseif(Auth::user()->Cstatus == "Both"){///{{Cstatus = User Type: Admin, Buyer, Seller, A customer who buys and sells item in fothebys as "Both" )
                // When a user  tries to access this view the Cstatus of the user will  be checked
                return $item->render('backend.Item.bothItem');

        }
        else
            return  redirect('/redirect');

    }


    //this function runs after the category is changed and according to the category the additional details of those category is added to the form with this function
    public function addDetail($id)
    {
        if(Auth::user()->Cstatus=="Admin") {
            $category = Item::find($id)->category()->first();
            $Subcategory = Item::find($id)->subCategory()->first();
            $classification = Item::find($id)->classification()->first();
            $client = Item::find($id)->client()->first();

            $item_value = DB::table('detail_item_value');
            $detail = Category::find($category->id)->detail()->get();
            $html = '';
            foreach ($detail as $get) {
                $detailValue = Detail::find($get->id)->detailValue()->get();
                $count = count($detailValue);
                $i = 0;
                $html = $html . '<div class="card-title">' . $get->name;
                foreach ($detailValue as $value) {
                    $i = $i + 1;
                    if ($value->type == "text") {
                        if ($value->name == "null") {
                            $item_value = DB::table('detail_item_value')->select('string')->where('item_id', '=', $id)->where('detail_value_id', '=', $value->id);
                            foreach ($item_value->get() as $valueName) {
                                $html = $html . ': ' . $valueName->string . '</div>';

//                            dd($html);


                            }
//dd($item_value->get());
                        } else {
                            $name = $value->name;
                            $item_value = DB::table('detail_item_value')->select('string')->where('item_id', '=', $id)->where('detail_value_id', '=', $value->id);
                            foreach ($item_value->get() as $valueName) {
                                if ($i == 1)
                                    $html = $html . '<p>' . $name . ': ' . $valueName->string;
                                else
                                    $html = $html . '        ' . $name . ': ' . $valueName->string;

                                if ($i == $count) {
                                    $html = $html . '</p></div>';
                                }
                            }


                        }
                    } elseif ($value->type == "number") {
                        if ($value->name == "null") {
                            $item_value = DB::table('detail_item_value')->select('integer')->where('item_id', '=', $id)->where('detail_value_id', '=', $value->id);
                            foreach ($item_value->get() as $valueName) {
                                $html = $html . ': ' . $valueName->integer . '</div>';
//                            dd($html);
                            }

                        } else {
                            $name = $value->name;

                            $item_value = DB::table('detail_item_value')->select('integer')->where('item_id', '=', $id)->where('detail_value_id', '=', $value->id);
                            foreach ($item_value->get() as $valueName) {
                                if ($i == 1)
                                    $html = $html . '<p>' . $name . ': ' . $valueName->integer;
                                else
                                    $html = $html . '        ' . $name . ': ' . $valueName->integer;
                                if ($i == $count) {
                                    $html = $html . '</p></div>';
                                }
                            }
                        }
                    } elseif ($value->type == "date") {
                        if ($value->name == "null") {
                            $item_value = DB::table('detail_item_value')->select('date')->where('item_id', '=', $id)->where('detail_value_id', '=', $value->id);
                            foreach ($item_value->get() as $valueName) {
                                $html = $html . ': ' . $valueName->date . '</div>';
//                            dd($html);
                            }

                        } else {
                            $name = $value->name;
                            $item_value = DB::table('detail_item_value')->select('date')->where('item_id', '=', $id)->where('detail_value_id', '=', $value->id);
                            foreach ($item_value->get() as $valueName) {
                                if ($i == 1)
                                    $html = $html . '<p>' . $name . ': ' . $valueName->date;
                                else
                                    $html = $html . '        ' . $name . ': ' . $valueName->date;
                                if ($i == $count) {
                                    $html = $html . '</p></div>';
                                }
                            }
                        }
                    }

                }
            }

            $item = Item::find($id);
            $image = Item::find($id)->image()->first();
            return view('backend.Item.addItemDetail')->with('category', $category)->with('SubCategory', $Subcategory)->with('classification', $classification)->with('client', $client)->with('item', $item)->with('html', $html)->with('image', $image);

        }
    else
            return  redirect('/redirect');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(Auth::user()->Cstatus=="Seller"||Auth::user()->Cstatus=="Both"){

        $category=Category::all()->pluck('name','id');
        $Subcategory=SubCategory::all()->pluck('name','id');
        $classification=Classification::all()->pluck('name','id');
            if(Auth::user()->Cstatus=="Both")
                $layout="bothLayout";
            if(Auth::user()->Cstatus=="Seller")
                $layout="sellerLayout";

            if(Auth::user()->Cstatus=="Buyer")
                $layout="buyerLayout";
            return view('backend.Item.createItem')->with('category',$category)->with('Subcategory',$Subcategory)->with('classification',$classification)->with('layout',$layout);

        }
        else{
            return redirect('/redirect');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item=new Item();
        if(Auth::user()->Cstatus=="Seller"||Auth::user()->Cstatus=="Both")
        $item->artists=$request->artists;
        $item->Piece_Title=$request->Piece_Title;
        $item->category_id=$request->category;
//        dd($request->Subcategory);
        if($request->Subcategory==null){
        }
        else{
            $item->subCategory_id=$request->Subcategory;

        }
        $item->from=$request->from;
        if($request->to=="null"){
        }
        else{
            $item->to=$request->to;

        }
        $item->client_id=Auth::user()->id;
        $item->classification_id=$request->classification;
        $item->description=$request->description;
        $item->customer_agreement=$request->agreement;

        $latestNumber = Item::orderBy('created_at','DESC')->first();
//        dd($latestNumber);

        if($latestNumber==null){
            $number=0;

            $number=str_pad($number + 1, 8, "0", STR_PAD_LEFT);
            $item->lastNumber = $number;
//            dd($item->lastNumber);

        }
        else{
            $number=(int)$latestNumber->lastNumber;

            $number=str_pad($number + 1, 8, "0", STR_PAD_LEFT);
            $item->lastNumber = $number;
//            dd($item->lastNumber);

        }
        $item->lotReferenceNumber=$number;
        $item->provenance_details = $request->provenance_details;
        $item->damage = $request->damage;
        $item->markings = $request->markings;
        $item->published = $request->published;

        if (!file_exists(public_path() . '/images/item/')) {
            mkdir(public_path() . '/images/item/');
        }
        if ($request->frontImage) {
            $file = $request->file('frontImage');
            $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/item/', $file_name);
//            dd($file_name);
            $item->frontImage = $file_name;
        }

        if (!file_exists(public_path() . '/images/item/')) {
            mkdir(public_path() . '/images/item/');
        }
        if ($request->backImage) {
            $file = $request->file('backImage');
            $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
            $file->move(public_path() . '/images/item/', $file_name);
//            dd($file_name);
            $item->backImage = $file_name;
        }

        $item->save();




        $item_value=DB::table('detail_item_value');
        $detail = Category::find($request->category)->detail()->get();
        foreach ($detail as $get) {
            $detailValue = Detail::find($get->id)->detailValue()->get();
//            $count = count($detailValue);
            foreach ($detailValue as $value) {

                if ($value->type == "text") {
                    if ($value->name == "null") {
                        $name = $get->name;
//                        dd($request->$name);
                        $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'string' => $request->$name]);

                    } else {
                        $name = $value->name;

                        $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'string' => $request->$name]);

                    }
                } elseif ($value->type == "number") {
                    if ($value->name == "null") {
                        $name = $get->name;
                        $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'integer' => $request->$name]);

                    } else {
                        $name = $value->name;

                        $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'integer' => $request->$name]);

                    }
                } elseif ($value->type == "date") {
                    if ($value->name == "null") {
                        $name = $get->name;
                        $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'date' => $request->$name]);

                    } else {
                        $name = $value->name;

                        $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'date' => $request->$name]);

                    }
                }
            }
//        $adValue=
        }
        return redirect('item/sold');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category=Item::find($id)->category()->first();
        $Subcategory=Item::find($id)->subCategory()->first();
        $classification=Item::find($id)->classification()->first();
        $client=Item::find($id)->client()->first();

        $item_value=DB::table('detail_item_value');
        $detail = Category::find($category->id)->detail()->get();
        $html='';
        foreach ($detail as $get) {
            $detailValue = Detail::find($get->id)->detailValue()->get();
            $count = count($detailValue);
            $i=0;
            $html=$html.'<div class="card-title col-md-3 col-sm-3 col-xs-3">'.$get->name.':</div>';
            foreach ($detailValue as $value) {
                $i=$i+1;
                if ($value->type == "text") {
                    if ($value->name == "null") {
                        $item_value=DB::table('detail_item_value')->select('string')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            $html=$html.'<div class="col-md-8 col-sm-8 col-xs-8"> '.$valueName->string.'</div>';

//                            dd($html);


                        }
//dd($item_value->get());
                    } else {
                        $name = $value->name;
                        $item_value=DB::table('detail_item_value')->select('string')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            if($i==1)
                                $html=$html.'<br><div class="card-title col-md-3 col-sm-3 col-xs-3">'.$name.':</div><div class="col-md-8 col-sm-8 col-xs-8">'.$valueName->string.'</div>';
                            else
                                $html=$html.'   <div class="card-title col-md-3 col-sm-3 col-xs-3">     '.$name.':</div><div class="col-md-8 col-sm-8 col-xs-8">'.$valueName->string.'</div>';


                        }


                    }
                } elseif ($value->type == "number") {
                    if ($value->name == "null") {
                        $item_value=DB::table('detail_item_value')->select('integer')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            $html=$html.'<div class="col-md-8 col-sm-8 col-xs-8"> '.$valueName->integer.'</div>';
//                            dd($html);
                        }

                    } else {
                        $name = $value->name;

                        $item_value=DB::table('detail_item_value')->select('integer')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            if($i==1)
                                $html=$html.'<span class="col-md-9"></span> <div class="card-title col-md-3 col-sm-3 col-xs-3">'.$name.':</div><div class="col-md-3 col-sm-3 col-xs-3">'.$valueName->integer.'</div>';
                            else
                                $html=$html.'<div class="card-title col-md-3 col-sm-3 col-xs-3">        '.$name.':</div><div class="col-md-3 col-sm-3 col-xs-3"> '.$valueName->integer.'</div>';

                        }
                    }
                } elseif ($value->type == "date") {
                    if ($value->name == "null") {
                        $item_value=DB::table('detail_item_value')->select('date')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            $html=$html.':<div class="col-md-8 col-sm-8 col-xs-8"> '.$valueName->date.'</div>';
//                            dd($html);
                        }

                    } else {
                        $name = $value->name;
                        $item_value=DB::table('detail_item_value')->select('date')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            if($i==1)
                                $html=$html.'<br><div class="card-title col-md-3 col-sm-3 col-xs-3">'.$name.':</div><div class="col-md-8 col-sm-8 col-xs-8">'.$valueName->date.'</div>';
                            else
                                $html=$html.' <br><div class="card-title col-md-3 col-sm-3 col-xs-3">       '.$name.':</div><div class="col-md-8 col-sm-8 col-xs-8"> '.$valueName->date.'</div>';

//
                        }
                    }
                }

            }
        }

        $item=Item::find($id);
if(Auth::user()->Cstatus=="Both")
    $layout="bothLayout";
if(Auth::user()->Cstatus=="Seller")
    $layout="sellerLayout";

        if(Auth::user()->Cstatus=="Buyer")
            $layout="buyerLayout";
        if(Auth::user()->Cstatus=="Admin")
            $layout="layout";

        return view('backend.Item.showItem')->with('category',$category)->with('SubCategory',$Subcategory)->with('classification',$classification)->with('client',$client)->with('item',$item)->with('html',$html)->with('layout',$layout);

    }

    public function frontShow($id)
    {
        $category=Item::find($id)->category()->first();
        $Subcategory=Item::find($id)->subCategory()->first();
        $classification=Item::find($id)->classification()->first();

        $detail = Category::find($category->id)->detail()->get();
        $html='';
        foreach ($detail as $get) {
            $detailValue = Detail::find($get->id)->detailValue()->get();
            $count = count($detailValue);
            $i=0;
            $html=$html.'<div class="card-title col-md-3 col-sm-3 col-xs-3">'.$get->name.':</div>';
            foreach ($detailValue as $value) {
                $i=$i+1;
                if ($value->type == "text") {
                    if ($value->name == "null") {
                        $item_value=DB::table('detail_item_value')->select('string')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            $html=$html.'<div class="col-md-8 col-sm-8 col-xs-8"> '.$valueName->string.'</div>';

//                            dd($html);


                        }
//dd($item_value->get());
                    } else {
                        $name = $value->name;
                        $item_value=DB::table('detail_item_value')->select('string')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            if($i==1)
                                $html=$html.'<br><div class="card-title col-md-3 col-sm-3 col-xs-3">'.$name.':</div><div class="col-md-8 col-sm-8 col-xs-8">'.$valueName->string.'</div>';
                            else
                                $html=$html.'   <div class="card-title col-md-3 col-sm-3 col-xs-3">     '.$name.':</div><div class="col-md-8 col-sm-8 col-xs-8">'.$valueName->string.'</div>';


                        }


                    }
                } elseif ($value->type == "number") {
                    if ($value->name == "null") {
                        $item_value=DB::table('detail_item_value')->select('integer')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            $html=$html.'<div class="col-md-8 col-sm-8 col-xs-8"> '.$valueName->integer.'</div>';
//                            dd($html);
                        }

                    } else {
                        $name = $value->name;

                        $item_value=DB::table('detail_item_value')->select('integer')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            if($i==1)
                                $html=$html.'<span class="col-md-9"></span> <div class="card-title col-md-3 col-sm-3 col-xs-3">'.$name.':</div><div class="col-md-3 col-sm-3 col-xs-3">'.$valueName->integer.'</div>';
                            else
                                $html=$html.'<div class="card-title col-md-3 col-sm-3 col-xs-3">        '.$name.':</div><div class="col-md-3 col-sm-3 col-xs-3"> '.$valueName->integer.'</div>';

                        }
                    }
                } elseif ($value->type == "date") {
                    if ($value->name == "null") {
                        $item_value=DB::table('detail_item_value')->select('date')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            $html=$html.':<div class="col-md-8 col-sm-8 col-xs-8"> '.$valueName->date.'</div>';
//                            dd($html);
                        }

                    } else {
                        $name = $value->name;
                        $item_value=DB::table('detail_item_value')->select('date')->where('item_id','=',$id)->where('detail_value_id','=',$value->id);
                        foreach ($item_value->get() as $valueName){
                            if($i==1)
                                $html=$html.'<br><div class="card-title col-md-3 col-sm-3 col-xs-3">'.$name.':</div><div class="col-md-8 col-sm-8 col-xs-8">'.$valueName->date.'</div>';
                            else
                                $html=$html.' <br><div class="card-title col-md-3 col-sm-3 col-xs-3">       '.$name.':</div><div class="col-md-8 col-sm-8 col-xs-8"> '.$valueName->date.'</div>';

//
                        }
                    }
                }

            }
        }



        $item=Item::find($id);

        return view('frontend.items')->with('category',$category)->with('SubCategory',$Subcategory)->with('classification',$classification)->with('item',$item)->with('html',$html);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->Cstatus=="Seller"||Auth::user()->Cstatus=="Both"){
            $category=Category::all()->pluck('name','id');
            $Subcategory=SubCategory::all()->pluck('name','id');
            $classification=Classification::all()->pluck('name','id');
            $expert=User::all()->where('Cstatus','=','Admin');
            $item=Item::find($id);
            if(Auth::user()->Cstatus=="Both")
                $layout="bothLayout";
            if(Auth::user()->Cstatus=="Seller")
                $layout="sellerLayout";

            if(Auth::user()->Cstatus=="Buyer")
                $layout="buyerLayout";
            return view('backend.Item.editItem')->with('item',$item)->with('category',$category)->with('Subcategory',$Subcategory)->with('classification',$classification)->with('expert',$expert)->with('layout',$layout);

        }
        else
            return  redirect('/redirect');
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
        $item=Item::find($id);
        if(Auth::user()->Cstatus=="Seller"||Auth::user()->Cstatus=="Both") {
            $item->artists = $request->artists;
            $item->Piece_Title = $request->Piece_Title;
            $item->category_id = $request->category;
            if ($request->Subcategory == null) {

            } else {
                $item->subCategory_id = $request->Subcategory;

            }
            $item->from = $request->from;
            if ($request->to == "null") {

            } else {
                $item->to = $request->to;

            }
            $item->client_id = Auth::user()->id;
            $item->classification_id = $request->classification;
            $item->description = $request->description;
            $item->customer_agreement = $request->customer_agreement;

            $latestNumber = Item::orderBy('created_at', 'DESC')->first();
//        dd($latestNumber);

            if ($latestNumber == null) {
                $number = 0;

                $number = str_pad($number + 1, 8, "0", STR_PAD_LEFT);
                $item->lastNumber = $number;
//            dd($item->lastNumber);

            } else {
                $number = (int)$latestNumber->lastNumber;

                $number = str_pad($number + 1, 8, "0", STR_PAD_LEFT);
                $item->lastNumber = $number;
//            dd($item->lastNumber);

            }
            $item->lotReferenceNumber = $number;

                $item->provenance_details = $request->provenance_details;
                $item->damage = $request->damage;
                $item->markings = $request->markings;
            $item->published = $request->published;


            if (!file_exists(public_path() . '/images/item/')) {
                mkdir(public_path() . '/images/item/');
            }
            if ($request->frontImage) {
                $file = $request->file('frontImage');
                $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/images/item/', $file_name);
//            dd($file_name);
                $item->frontImage = $file_name;
            }

            if (!file_exists(public_path() . '/images/item/')) {
                mkdir(public_path() . '/images/item/');
            }
            if ($request->backImage) {
                $file = $request->file('backImage');
                $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/images/item/', $file_name);
//            dd($file_name);
                $item->backImage = $file_name;
            }
            $item->save();


            $item_value = DB::table('detail_item_value');
            $item_value->where('item_id', '=', $id)->delete();

            $detail = Category::find($request->category)->detail()->get();
            foreach ($detail as $get) {
                $detailValue = Detail::find($get->id)->detailValue()->get();
//            $count = count($detailValue);
                foreach ($detailValue as $value) {

                    if ($value->type == "text") {
                        if ($value->name == "null") {
                            $name = $get->name;
                            $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'string' => $request->$name]);

                        } else {
                            $name = $value->name;

                            $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'string' => $request->$name]);

                        }
                    } elseif ($value->type == "number") {
                        if ($value->name == "null") {
                            $name = $get->name;
                            $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'integer' => $request->$name]);

                        } else {
                            $name = $value->name;

                            $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'integer' => $request->$name]);

                        }
                    } elseif ($value->type == "date") {
                        if ($value->name == "null") {
                            $name = $get->name;
                            $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'date' => $request->$name]);

                        } else {
                            $name = $value->name;

                            $item_value->insert(['item_id' => $item->id, 'detail_value_id' => $value->id, 'date' => $request->$name]);

                        }
                    }
                }

//        $adValue=
            }
        }
        elseif(Auth::user()->Cstatus=="Admin"){
//            $get=Item::find($request->item_id);
//            dd($request->expert_name);
//            dd($get->Piece_Title);
            $item->update([

                'estimated_price_from'=>$request->estimated_price_from,
                'estimated_price_to'=>$request->estimated_price_to,
                'authenticated'=>$request->authenticated,
                'additional_notes'=>$request->additionalNote,

                'expert_id'=>Auth::user()->id,
                'approved'=>$request->approve,
                'signed_date'=>date('Y-m-d'),

                'expert_name'=>$request->expert_name,
                'reservePrice'=>$request->reservePrice


            ]);

            if($request->approve=="allowed"){
                $client = User::find($request->client_id);
                $name = $client->FirstName;
                $email = $client->email;

                $get=Item::find($request->item_id);
                $body =

                        "Dear " . $client->FirstName . ",
                        
                        We are pleased to inform you that your piece, " . $get->Piece_Title . " Lot Reference Number: ".$get->lotReferenceNumber.", has been Verified for sale at our auction. The estimated value of your item is £".$request->estimated_price_from." to £".$request->estimated_price_to."
                        
                        Mr M Fotherby
                        ";

                $data = array('name' => $name, "body" => $body);

                Mail::send('backend.mail.mail', $data, function ($message) use ($name, $email) {
                    $message->from('shivakhatri665@gmail.com', 'Shiva');

                    $message->to($email, $name)->subject('Item Verification');
                });
            }
            if (!file_exists(public_path() . '/images/item/')) {
                mkdir(public_path() . '/images/item/');
            }
            $imageTable = DB::table('images');
            $imageTable->where('item_id', '=', $id)->delete();
//dd($request->images);
            foreach ($request->images as $getImage) {
//                dd('here');
                $file = $getImage;
//                dd($file);
                $file_name = rand(1345, 9898) . '_' . $file->getClientOriginalName();
                $file->move(public_path() . '/images/item/', $file_name);
//            dd($file_name);
                $images=new Image();
                $images->admin_id=Auth::user()->id;
                $images->item_id=$id;
                $images->image = $file_name;
                $images->save();

            }
        }
        return redirect('item');
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
if(Auth::user()->Cstatus=="Both"||Auth::user()->Cstatus=="Seller"){
    $item=Item::find($id)->where('approve','=','allowed');
    $remove_price=$item->estimated_price_from*(5/100);
    $income=new Income();
    $income->client_id=Auth::user()->id;
    $income->item_id=$id;
    $income->remove_price=$remove_price;
    $income->save();
}

        $item_value=DB::table('detail_item_value');//assigns item value with detail item model
        $item_value->where('item_id','=',$id)->delete();//deletes the row whose item id matches with the $id
        Item::destroy($id);//deletes the item whose item matches the given id
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Item::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

    //for related select box
    public function ajax($id)
    {

        $detail = Category::find($id)->detail()->get();
        $subcategory= Category::find($id)->subCategory()->get()->pluck('name','id');
//        $detailName='';
        $html='';

        foreach ($detail as $get){
            $html=$html. '<div   class="form-group row">
                            <label for="type" class="control-label col-md-9 col-sm-9 col-xs-12" >'.$get->name.'</label>';
//            dd($get->id);

            $detailValue=Detail::find($get->id)->detailValue()->get();
            $count=count($detailValue);
            $i=0;
//            dd($detailValue);
            foreach($detailValue as $value){
                $i=$i+1;
                if($value->name=="null"){
                    $html=$html. '  <input name="'.$get->name.'"
                                           class="form-control col-lg-6 col-md-6 col-sm-6 col-xs-12"
                                           type = "'.$value->type.'"
                                    />
                                </div>';
                }
                else{
                    $html=$html. '                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <label for="type" class="control-label col-md-6 col-sm-6 col-xs-12" >'.$value->name.'</label>
                                    <input name="'.$value->name.'"
                                           class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                           type = "'.$value->type.'"
                                    />
                                </div>';
                    if($count==$i){
                        $html=$html. '</div>';
                    }
                }
            }
//            dd($count);
        }

$data=['0'=>$html,'1'=>$subcategory];
//        dd($detail);
        return json_encode($data);
    }

    public function ajaxEdit($use,$id)
    {

        $detail = Category::find($id)->detail()->get();
        $subcategory= Category::find($id)->subCategory()->get()->pluck('name','id');

//        $detailName='';
        $html='';

        foreach ($detail as $get){
            $html=$html. '<div   class="form-group row">
                            <label for="type" class="control-label col-md-9 col-sm-9 col-xs-12" >'.$get->name.'</label>';
//            dd($get->id);

            $detailValue=Detail::find($get->id)->detailValue()->get();
            $count=count($detailValue);
            $i=0;
//            dd($detailValue);
            foreach($detailValue as $value){
                $i=$i+1;
                if($value->name=="null"){
                    $html=$html. '  <input name="'.$get->name.'"
                                           class="form-control col-lg-6 col-md-6 col-sm-6 col-xs-12"
                                           type = "'.$value->type.'"
                                    />
                                </div>';
                }
                else{
                    $html=$html. '                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
                                    <label for="type" class="control-label col-md-6 col-sm-6 col-xs-12" >'.$value->name.'</label>
                                    <input name="'.$value->name.'"
                                           class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12"
                                           type = "'.$value->type.'"
                                    />
                                </div>';
                    if($count==$i){
                        $html=$html. '</div>';
                    }
                }
            }
//            dd($count);
        }


//        dd($detail);
        $data=['0'=>$html,'1'=>$subcategory];
        return json_encode($data);
    }

}
