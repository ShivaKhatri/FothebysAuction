<?php

namespace App\DataTables;

use App\Model\Item;
use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class soldDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('action', function ($detail) {
                $item=Item::find($detail->id);
                $auction=$item->auction()->first();

                if($auction->sold==null)
                return '<a href="'.route('item.show',$detail->id).'" class="btn btn-sm btn-success" style="margin:3px">
                         Show</a><a href="'.route('item.edit',$detail->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.route('item.destroy',$detail->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
           else
               return '<a href="'.route('item.show',$detail->id).'" class="btn btn-sm btn-success" style="margin:3px">
                         Show</a><a href="'.route('item.edit',$detail->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>';


            })
            ->addColumn('Auction_Date', function ($detail) {

                $Dname=Item::find($detail->id)->auction()->first();
                if($Dname==null){
                    $wow='<strong>In process to be assigned to a auction</strong>';

                }
                else
                    $wow=$Dname->date;
//                dd($wow);
                return $wow;
            })
            ->addColumn('status', function ($detail) {
                $wow='';
                $Dname=Item::find($detail->id);
                if($Dname->approved=="allowed"){
                    $wow='<strong style="text-decoration-color: #0b2e13">Verified</strong>';

                }
                elseif($Dname->approved=="notAllowed"){
                    $wow='<strong style="text-decoration-color: #0b2e13">Rejected</strong>';

                }
                elseif($Dname->approved==null){
                    $wow='<strong style="text-decoration-color: #0b2e13">In Review</strong>';

                }
                return $wow;
            })
            ->editColumn('sold', function($item) {
                if($item->sold==null){
                    return 'Not Sold';

                }
                else
                    return  $item->sold ;
            })
            ->rawColumns(['status','sold','Auction_Date','action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Item $model)
    {
        $id=Auth::user()->id;
        return $model->newQuery()->select('id','lotReferenceNumber', 'sold','estimated_price_from', 'estimated_price_to', 'reservePrice')->where('client_id','=',$id);

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
                    ->parameters($this->getShowParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'lotReferenceNumber',
            'sold',
            'status',
            'estimated_price_from',
            'estimated_price_to',
            'reservePrice',
            'Auction_Date',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'sold_' . date('YmdHis');
    }
}
