<?php

namespace App\DataTables;

use App\Model\Item;
use App\User;
use Yajra\DataTables\Services\DataTable;

class AuctionedItemDatatable extends DataTable
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
                return '<a href="'.route('item.show',$detail->id).'" class="btn btn-sm btn-success" style="margin:3px">
                         Show</a><a href="'.route('item.edit',$detail->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.route('item.destroy',$detail->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->addColumn('sold_by', function ($detail) {

                $Dname=Item::find($detail->id)->client()->first();
                $wow='<strong>'.$Dname->FirstName.' '. $Dname->Surname.'</strong>';
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
            ->rawColumns(['status','sold','sold_by','action']);
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Item $model)
    {
        return $model->newQuery()->select('id','lotReferenceNumber', 'sold','estimated_price_from', 'estimated_price_to', 'reservePrice')->where('approved','=','notAllowed');

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
                    ->addAction(['width' => '80px'])
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
            'sold_by',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AuctionedItem_' . date('YmdHis');
    }
}
