<?php

namespace App\DataTables;

use App\Model\Auction;
use App\User;
use Yajra\DataTables\Services\DataTable;

class AuctionDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)//to show the details of the auction
    {
        return datatables($query)
            ->addColumn('action', function ($detail) {
                $Dname=Auction::find($detail->id);

                if($Dname->status==0){//if the auction has no been published the action column will include the publish button
                    return '<a href="'.route('auction.publish',$detail->id).'" class="btn btn-sm btn-success" style="margin:3px">
                         Publish</a><a href="'.route('auction.edit',$detail->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.route('auction.destroy',$detail->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';

                }
                else{
                    return '<a href="'.route('auction.edit',$detail->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.route('auction.destroy',$detail->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';


                }
           })
            ->addColumn('Added_by', function ($detail) {//to show who added the auction

                $Dname=Auction::find($detail->id)->admin()->first();
                $wow='<strong>'.$Dname->FirstName.' '. $Dname->Surname.'</strong>';
//                dd($wow);
                return $wow;
            })
            ->addColumn('status', function ($detail) {// to show if the auction has been published or not
                $wow='';
                $Dname=Auction::find($detail->id);
                if($Dname->status==0){
                    $wow='<strong style="text-decoration-color: #0b2e13">Pending</strong>';

                }
                elseif($Dname->status==1){
                    $wow='<strong style="text-decoration-color: #0b2e13">Confirmed</strong>';

                }
                return $wow;
            })
            ->addColumn('theme', function($auction) {//theme of the auction
                $Dname=Auction::find($auction->id);
                if($Dname->themeName=="Category"){//if the  theme of the auction is named  based on category
                    $category=$Dname->category()->first();
                    $wow='<strong style="text-decoration-color: #0b2e13">'.$category->name.'</strong>';

                }
                else{//if the theme of the auction is based on the artists name
                    $wow='<strong style="text-decoration-color: #0b2e13">'.$Dname->themeValue.'</strong>';

                }

                return $wow;
            })
            ->editColumn('session', function($auction) {//checks the session of the auction
                $Dname=Auction::find($auction->id);
                if($Dname->session==1){
                    $wow='<strong style="text-decoration-color: #0b2e13">First Session</strong>';

                }
                elseif($Dname->session==2){
                    $wow='<strong style="text-decoration-color: #0b2e13">Second Session</strong>';

                }
                elseif($Dname->session==3){
                    $wow='<strong style="text-decoration-color: #0b2e13">Third Session</strong>';

                }

                return $wow;
            })
            ->rawColumns(['status','theme','Added_by','action','session']);//the html elements in the column will not be printed as
                                                                            //they are instead the element will work as intended
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Auction $model)
    {
        return $model->newQuery()->select('id', 'description', 'location','session','date');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '180px'])
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'description', 'location','session','date',
            'theme',
            'status',
            'Added_by'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Auction_' . date('YmdHis');
    }
}
