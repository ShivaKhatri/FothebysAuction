<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AuctionDatatable;
use App\Model\Auction;
use App\Model\Category;
use App\Model\Item;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AuctionDatatable $datatable)
    {
        $Cstatus=Auth::user()->Cstatus;
        if($Cstatus=="Admin")
        return $datatable->render('backend.Auction.indexAuction');
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
        $Cstatus=Auth::user()->Cstatus;
        if($Cstatus=="Admin") {
            $category = Category::all()->pluck('name', 'id');
            return view('backend.Auction.createAuction')->with('category', $category);
        }
        else
            return redirect('/redirect');


//        return redirect('auction/create')->with('message', 'The selected session is already assigned to auction lot: ');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getAuction=Auction::all();
        $num=count($getAuction);
//        foreach ($count as $get){
//
//                dd($get->date);
//
//
//            }
        foreach ($getAuction as $get){
            if($get->date==$request->date){
                if($get->session==$request->sessionAuction & $get->location==$request->location){
//                    dd($request->location);

                    return redirect('auction/create')->with('message', 'The selected session is already assigned to auction lot: '.$get->lotNumber);

                }
            }
        }
        $auction=new Auction();
        $auction->themeName=$request->theme;
        $auction->lotNumber=$num+1;
        if($request->theme=='Category') {
            $count = Item::all()->where('category_id', '=', $request->themeValue)->where('approved', '=', 'allowed')->count();
            if ($count > 80) {
                $auction->status=1;
            }
            else {
//                dd($request->status);
                if($request->status==1)
                    return redirect('auction/create')->with('message', 'The category dosen\'t have enough items to be on a auction');

                $auction->status=0;

            }
        }
        elseif ($request->theme=='artists'){
            $count = Item::all()->where('artists', '=', $request->themeValue)->where('approved', '=', 'allowed')->count();
            if ($count > 10) {
                $auction->status=1;

            } else {

                if($request->status==1)
                    return redirect('auction/create')->with('message', 'The Artist dosen\'t have enough items !');

                $auction->status=0;

            }
        }
        $auction->themeValue = $request->themeValue;
        $auction->description = $request->description;

        $auction->location = $request->location;
        $auction->date = $request->date;
        $auction->session = $request->sessionAuction;
        $auction->admin_id = Auth::user()->id;
        $auction->save();
        if($auction->status==1){
            $this->sendMail($auction->id);
        }
        $id=$auction->id;
//dd($request->theme);
        if($request->theme=='Category'){
            $item= Item::query()->where('category_id', '=', $request->themeValue)->where('approved', '=', 'allowed')->where('auction_id', '=', null)->get();
//            dd($item);

            foreach ($item as $get) {
                $name='item'.$get->id;
//dd($name);
                if(!($request->$name==null)){
                    $itemAuctoin=Item::find($get->id);
                    $itemAuctoin->update([
                        'auction_id'=>$id,
                        'lotNumber'=>$auction->lotNumber
                    ]);

                }

            }
        }
        if($request->theme=="artists"){
            $item = Item::query()->where('artists', 'LIKE', "%{$auction->themeValue}%" )->where('approved', '=', 'allowed')->where('auction_id', '=', null)->get();
            foreach ($item as $get) {
                $name='item'.$get->id;
                if(!($request->$name==null)){
                    $itemAuctoin=Item::find($get->id);
                    $itemAuctoin->update([
                        'auction_id'=>$auction->id,
                        'lotNumber'=>$auction->lotNumber
                    ]);


                }
            }
        }
        return redirect('/auction')->with('message','Auction has been created successfully');

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

        $category=Category::all()->pluck('name','id');
        $auction=Auction::find($id);
        return view('backend.Auction.editAuction')->with('category',$category)->with('auction',$auction);

    }

    public function publish($id)
    {

        $auction=Auction::find($id);
        $count=Item::query()->where('auction_id','=',$id)->count();

        if($auction->themeName=="artists")
        {
            if($count>10){
                $message="This Auction Contains Enough Item To Be Auctioned";
            }
            else{
                $message="This Auction Still Needs More Items To Publish";

            }
            //selects items which is verified and whose artists name matches with the given value($id)
            $item = Item::query()->where('artists' , 'LIKE', "%{ $auction->themeValue}%" )->where('approved', '=', 'allowed')->get();

            //saving the html codes to be displayed in view here. this is the initialization of the variable $html.
            $html=' <label for="type" class="control-label col-md-12 col-sm-12 col-xs-12" ><h6>Select Items For Auction</h6></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 d-flex justify-content-between row">
';
            foreach ($item as $get){

//            $html=$html. '<input type="checkbox" name="item'.$get->id.'" value="'.$get->id.'"><a href="'.route("item.show",$get->id).'"> Lot Reference Number:'.$get->lotReferenceNumber.' '.$get->Piece_Title.'</a></input>';
                $html= $html.'<div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 5px"><div class="card">
                  <div class="card-header ">
                          <input type="checkbox" class="form-control" name="item'.$get->id.'" value="'.$get->id.'">
                  </div>
                  <div class="card-body">
                    <p class="card-text"> Piece Title:'. $get->Piece_Title.'<br>Lot Reference Number: '. $get->lotReferenceNumber.'<br>Artist: '.$get->artists.'</p>
                    <a href="'.route("item.show",$get->id).'" class="btn btn-primary">View Item</a>
                  </div>&nbsp;&nbsp;
</div></div>';
            }
            $html=$html.'</div>';
        }
        if($auction->themeName=="Category"){
            if($count>80){
                $message="This Auction Contains Enough Item To Be Auctioned";
            }
            else{
                $message="This Auction Still Needs More Items To Publish";

            }
            $item = Item::all()->where('category_id', '=', $auction->themeValue)->where('approved', '=', 'allowed')->where('auction_id', '=', null);
            $html=' <label for="type" class="control-label col-md-12 col-sm-12 col-xs-12" ><h6>Select Items For Auction</h6></label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 d-flex justify-content-between row">
';
            $i=0;
            foreach ($item as $get){
                $i=$i+1;

//            $html=$html. '<input type="checkbox" name="item'.$get->id.'" value="'.$get->id.'"><a href="'.route("item.show",$get->id).'"> Lot Reference Number:'.$get->lotReferenceNumber.' '.$get->Piece_Title.'</a></input>';
                $html= $html.'<div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 5px"><div class="card">
                  <div class="card-header ">
                          <input type="checkbox" class="form-control" name="item'.$get->id.'" value="'.$get->id.'">
                  </div>
                  <div class="card-body">
                    <p class="card-text"> Piece Title:'. $get->Piece_Title.'<br>Lot Reference Number: '. $get->lotReferenceNumber.'<br>Artist: '.$get->artists.'</p>
                    <a href="'.route("item.show",$get->id).'" class="btn btn-primary">View Item</a>
                  </div>&nbsp;&nbsp;
</div></div>';
            }
            if($i==0){
                $html=null;

            }
            else
                $html=$html.'</div>';
        }
        return view('backend.Auction.publish')->with('auction',$auction)->with('html',$html)->with('count',$count)->with('message',$message);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendMail($id){
        $itemAuctoin=Auction::find($id)->item()->get();
        $auction=Auction::find($id);
        foreach ($itemAuctoin as $get) {
            $Cid = $get->client_id;
            $client = User::find($Cid);
            $name = $client->FirstName;
            $email = $client->email;
            $date = date('Y-m-d');
            $newdate = strtotime('-14 day', strtotime($date));
            $newdate = date('Y-m-d', $newdate);
            $price = $get->estimated_price_from * (5 / 100);

            $body = "Date: " . $date . "

                        Dear " . $client->FirstName . ",
                        
                        We are pleased to inform you that your piece, " . $get->PieceTitle . ", has been scheduled for sale at our auction house in " . $auction->location . " on " . $auction->date . ".
                        
                        May I take this opportunity to remind you that should you wish to withdraw your item from the sale, you must notify this department by " . $newdate . ". Any requests to withdraw the piece form sale after the stated deadline will result in a fee equivalent to 5% of the lower estimated price for your piece, this being £ " . $price . ", in line with your original sale agreement.    
                        
                        May I also take this opportunity again to thank you for using Fotherby’s auction house, as we seek to achieve the best possible selling price for your item.
                        
                        Yours Sincerely,
                        
                        
                        Mr M Fotherby
                        ";

            $data = array('name' => $name, "body" => $body);

            Mail::send('backend.mail.mail', $data, function ($message) use ($name, $email) {
                $message->from('shivakhatri665@gmail.com', 'Shiva');

                $message->to($email, $name)->subject('Your Reminder!');
            });
        }

    }


    public function update(Request $request, $id)
    {
        $countArtist = Item::query()->where('artists', 'LIKE', "%{$request->themeValue}%" )->where('approved', '=', 'allowed')->count();
        $count = Item::query()->where('category_id', '=', $request->themeValue)->where('approved', '=', 'allowed')->count();
//dd('here');
//        dd($count);

        $getAuction=Auction::all();
        $num=count($getAuction);

        foreach ($getAuction as $get){
            if($get->date==$request->date){
                if($get->session==$request->sessionAuction & $get->location==$request->location & $get->id!=$id){
//                    dd($request->location);

                    return redirect(route('auction.publish',$id))->with('message', 'The selected session is already assigned to auction lot: '.$get->lotNumber);

                }
            }
        }
        $auction=Auction::find($id);
        $auction->themeName=$request->theme;
        $auction->lotNumber=$num;
        if($request->theme=='Category') {
//            $count =0;
                if ($count > 80) {
                $auction->status=1;
                $this->sendMail($id);
            }
            else {
//                dd($request->status);
                if($request->status==1)
                    return redirect(route('auction.publish',$id))->with('message', 'The Auction dosen\'t have enough items to be published');

                $auction->status=0;

            }
        }
        elseif ($request->theme=='artists'){
            if ($countArtist > 10) {
                $auction->status=1;
                $this->sendMail($id);


            } else {

                if($request->status==1)
                    return redirect(route('auction.publish',$id))->with('message', 'The Auction dosen\'t have enough items to be published!');

                $auction->status=0;


            }
        }
//        dd('here');

        $auction->themeValue = $request->themeValue;
        $auction->description = $request->description;

        $auction->location = $request->location;
        $auction->date = $request->date;
        $auction->session = $request->sessionAuction;
        $auction->admin_id = Auth::user()->id;
        $auction->save();
        $id=$auction->id;
//dd($request->theme);
        if($request->theme=='Category'){

            $item= Item::query()->where('category_id', '=', $request->themeValue)->where('approved', '=', 'allowed')->where('auction_id', '=', null)->orWhere('auction_id', '=', $id)->get();
//            dd($item);

            foreach ($item as $get) {
                $name='item'.$get->id;
//dd($name);
                if(!($request->$name==null)){
                    $itemAuctoin=Item::find($get->id);
                    $itemAuctoin->update([
                        'auction_id'=>$id,
                        'lotNumber'=>$auction->lotNumber
                    ]);


                }

            }
        }
        if($request->theme=="artists"){
            $item = Item::query()->where('artists', 'LIKE', "%{$auction->themeValue}%" )->where('approved', '=', 'allowed')->where('auction_id', '=', null)->orWhere('auction_id', '=', $id)->get();
            foreach ($item as $get) {
                $name='item'.$get->id;
                if(!($request->$name==null)){
                    $itemAuctoin=Item::find($get->id);
                    $itemAuctoin->update([
                        'auction_id'=>$auction->id,
                        'lotNumber'=>$auction->lotNumber
                    ]);

                }
            }
        }
        return redirect('auction')->with('message', 'The Auction is saved ');

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
            return response()->json([
                'success' => 'Record not deleted!'
            ]);
        }


        Auction::destroy($id);//deletes the item whose item matches the given id
        return response()->json([
            'success' => 'Record deleted successfully!'
        ]);
    }

    public function checkId($id)
    {
        $query = Auction::all();
        $query->where('id', '=', $id);
        $this->model = $query->first();

        return $this->model;
    }

    public function theme($id)
    {
//        dd($id);foreach (array_expression as $key => $value)
        $category=Category::all()->pluck('name','id');
        if($id=="Category"){
            $web='';
            foreach ($category as $key => $value){
//          dd($key);
                $web=$web.'<option value="'.$key.'">'.$value.'</option>';

            }
            $html=' <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >Category</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control category" name="themeValue" >
                                                        <option value="">Select Category</option>

                               '.$web.'
                            </select>
                            </div>
                        </div>';
        }
        if($id=="artists"){
            $html=' <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >Artists Name</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control artists" name="themeValue">
                            </div>
                        </div>
                        ';
        }


//        dd($detail);
        return json_encode($html);
    }

    public function ajax($id)
    {
//        $category= Category::find($id)->get()->pluck('name','id');

        $item = Item::all()->where('category_id', '=', $id)->where('approved', '=', 'allowed')->where('auction_id', '=', null);
        $html=' <label for="type" class="control-label col-md-12 col-sm-12 col-xs-12" >Select Items For Auction</label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 d-flex justify-content-between row">
';
        $i=0;
        foreach ($item as $get){
            $i=$i+1;

//            $html=$html. '<input type="checkbox" name="item'.$get->id.'" value="'.$get->id.'"><a href="'.route("item.show",$get->id).'"> Lot Reference Number:'.$get->lotReferenceNumber.' '.$get->Piece_Title.'</a></input>';
            $html= $html.'<div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 5px"><div class="card">
                  <div class="card-header ">
                          <input type="checkbox" class="form-control" name="item'.$get->id.'" value="'.$get->id.'">
                  </div>
                  <div class="card-body">
                    <p class="card-text"> Piece Title:'. $get->Piece_Title.'<br>Lot Reference Number: '. $get->lotReferenceNumber.'<br>Artist: '.$get->artists.'</p>
                    <a href="'.route("item.show",$get->id).'" class="btn btn-primary">View Item</a>
                  </div>&nbsp;&nbsp;
</div></div>';
        }
        $html=$html.'</div>';

//        dd($detail);
        return json_encode($html);
    }
    public function artists($id)
    {
        //selects items which is verified and whose artists name matches with the given value($id)
        $item = Item::query()->where('artists' , 'LIKE', "%{$id}%" )->where('approved', '=', 'allowed')->where('auction_id', '=', null)->get();

        //saving the html codes to be displayed in view here. this is the initialization of the variable $html.
        $html=' <label for="type" class="control-label col-md-12 col-sm-12 col-xs-12" >Select Items For Auction</label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 d-flex justify-content-between row">
';
        foreach ($item as $get){

//            $html=$html. '<input type="checkbox" name="item'.$get->id.'" value="'.$get->id.'"><a href="'.route("item.show",$get->id).'"> Lot Reference Number:'.$get->lotReferenceNumber.' '.$get->Piece_Title.'</a></input>';
            $html= $html.'<div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 5px"><div class="card">
                  <div class="card-header ">
                          <input type="checkbox" class="form-control" name="item'.$get->id.'" value="'.$get->id.'">
                  </div>
                  <div class="card-body">
                    <p class="card-text"> Piece Title:'. $get->Piece_Title.'<br>Lot Reference Number: '. $get->lotReferenceNumber.'<br>Artist: '.$get->artists.'</p>
                    <a href="'.route("item.show",$get->id).'" class="btn btn-primary">View Item</a>
                  </div>&nbsp;&nbsp;
</div></div>';
        }
        $html=$html.'</div>';
//        dd($detail);
        return json_encode($html);
    }

    public function themeEdit($use,$id)
    {
//        dd($id);foreach (array_expression as $key => $value)
        $category=Category::all()->pluck('name','id');
        $auction=Auction::find($use);
        if($id=="Category"){
            $web='';
            foreach ($category as $key => $value){
//          dd($key);
                if($auction->themeValue==$key) {
                    $web = $web . '<option value="' . $key . '" selected>' . $value . '</option>';
                }
                else{
                    $web = $web . '<option value="' . $key . '">' . $value . '</option>';

                }

            }
            $html=' <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >Category</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control category" name="themeValue" >
                            <option value="">Select Category</option>
                               '.$web.'
                            </select>
                            </div>
                        </div>';
        }
        if($id=="artists"){
            $html=' <div   class="form-group ">
                            <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12" >Artists Name</label>

                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" class="form-control artists" name="themeValue" value="'.$auction->themeValue.'">
                            </div>
                        </div>
                        ';
        }


//        dd($detail);
        return json_encode($html);
    }

    public function ajaxEdit($use,$id)
    {

        $item = Item::query()->where('category_id', '=', $id)->where('approved', '=', 'allowed')->orWhere('auction_id', '=', $use)->where('auction_id', '=', null)->get();
        $html=' <label for="type" class="control-label col-md-12 col-sm-12 col-xs-12" >Select Items For Auction</label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 d-flex justify-content-between row">
';
//        dd($item);

        $i=0;
        foreach ($item as $get){
            $i=$i+1;
if($get->auction_id==$use)
    $check="checked";
else
    $check='';
//            $html=$html. '<input type="checkbox" name="item'.$get->id.'" value="'.$get->id.'"><a href="'.route("item.show",$get->id).'"> Lot Reference Number:'.$get->lotReferenceNumber.' '.$get->Piece_Title.'</a></input>';
            $html= $html.'<div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 5px"><div class="card">
                  <div class="card-header ">
                          <input type="checkbox" class="form-control" name="item'.$get->id.'" value="'.$get->id.'" '.$check.'>
                  </div>
                  <div class="card-body">
                    <p class="card-text"> Piece Title:'. $get->Piece_Title.'<br>Lot Reference Number: '. $get->lotReferenceNumber.'<br>Artist: '.$get->artists.'</p>
                    <a href="'.route("item.show",$get->id).'" class="btn btn-primary">View Item</a>
                  </div>&nbsp;&nbsp;
</div></div>';
        }
        $html=$html.'</div>';

//        dd($detail);
        return json_encode($html);
    }

    public function artistEdit($use,$id)
    {
//        dd('here');
//selects items which is verified and whose artists name matches with the given value($id)
        $item = Item::query()->where('artists' , 'LIKE', "%{$id}%" )->where('approved', '=', 'allowed')->where('auction_id', '=', null)->orWhere('auction_id', '=', $use)->get();

        //saving the html codes to be displayed in view here. this is the initialization of the variable $html.
        $html=' <label for="type" class="control-label col-md-12 col-sm-12 col-xs-12" >Select Items For Auction</label><div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 d-flex justify-content-between row">
';
        foreach ($item as $get){

//            $html=$html. '<input type="checkbox" name="item'.$get->id.'" value="'.$get->id.'"><a href="'.route("item.show",$get->id).'"> Lot Reference Number:'.$get->lotReferenceNumber.' '.$get->Piece_Title.'</a></input>';
            $html= $html.'<div class="col-md-4 col-sm-4 col-xs-12" style="margin-top: 5px"><div class="card">
                  <div class="card-header ">
                          <input type="checkbox" class="form-control" name="item'.$get->id.'" value="'.$get->id.'">
                  </div>
                  <div class="card-body">
                    <p class="card-text"> Piece Title:'. $get->Piece_Title.'<br>Lot Reference Number: '. $get->lotReferenceNumber.'<br>Artist: '.$get->artists.'</p>
                    <a href="'.route("item.show",$get->id).'" class="btn btn-primary">View Item</a>
                  </div>&nbsp;&nbsp;
</div></div>';
        }
        $html=$html.'</div>';
//        dd($detail);
        return json_encode($html);
    }

}
