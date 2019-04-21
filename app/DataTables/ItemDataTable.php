<?php

namespace App\DataTables;

use App\Model\Item;
use App\User;
use Yajra\DataTables\Services\DataTable;

class ItemDataTable extends DataTable
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
                $verify=Item::find($detail->id);
                if($verify->approved=="allowed"){
                    $review='';

                }
                else
                    $review='<a href="'.route('item.addDetail',$detail->id).'" class="btn btn-sm btn-success" style="margin:3px">
                        Review</a>';

                return $review.'<a href="'.route('item.show',$detail->id).'" class="btn btn-sm btn-warning" style="margin:3px">
                         Show</a><a href="'.route('item.addDetail',$detail->id).'" class="btn btn-sm btn-primary" style="margin:3px">
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
            ->editColumn('sold_at', function($item) {
                if($item->sold==null){
                    return 'Not Sold';

                }
                else
                return  $item->sold ;
            })
            ->editColumn('estimated_price_from', function($item) {
                if($item->estimated_price_from==null){
                    return 'In Review';

                }
                else
                return  $item->estimated_price_from ;
            })
            ->editColumn('estimated_price_to', function($item) {
                if($item->estimated_price_to==null){
                    return 'In Review';

                }
                else
                return  $item->estimated_price_to ;
            })
            ->rawColumns(['status','sold_at','sold_by','action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Item $model)
    {
        return $model->newQuery()->select('id','lotReferenceNumber', 'sold','estimated_price_from', 'estimated_price_to', 'reservePrice');
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
            'sold_at',
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
        return 'Item_' . date('YmdHis');
    }
}
