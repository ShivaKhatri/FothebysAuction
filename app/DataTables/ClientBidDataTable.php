<?php

namespace App\DataTables;

use App\Model\Commission_Bid;
use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Services\DataTable;

class ClientBidDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)//to show the details of the commission bid in a auction
    {
        return datatables($query)
            ->addColumn('Auction', function ($getId) {
                $commission=Commission_Bid::find($getId->id)->auction()->first();
                if($commission->themeName=="Category"){
                    $category=Category::find($commission->themeValue);
                    $wow='<b>Theme: '.$category->name.'</b><br> Lot No: '.$commission->lotNumber;

                }
                elseif($commission->themeName=="artists")
                    $wow='<b>Theme Artist-Based:'.$commission->themeValue.'</b><br> Lot No: '.$commission->lotNumber;

                return $wow;
            })
            ->addColumn('Item', function ($getId) {
                $item=Commission_Bid::find($getId->id)->item()->first();
                $wow='<b>'.$item->Piece_Title.'</b><br> Lot Reference Number: '.$item->lotReferenceNumber;
                return $wow;
            })
            ->addColumn('action', function ($category) {
                $commission=Commission_Bid::find($category->id)->auction()->first();
$today=date('Y-m-d');
$today=new \DateTime($today);
$auction=new \DateTime($commission->auction_date);
                if($auction<$today)
                    return '<div class="alert alert-success" role="alert">
  Auction Has Already been conducted
</div>';

                else
                return '<a href="'.route('commission.edit',$category->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.route('commission.destroy',$category->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->rawColumns(['Item','Auction', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Commission_Bid $model)
    {
        $id=Auth::user()->id;
        return $model->newQuery()->select('id',  'open',
            'max', 'created_at')->where('client_id','=',$id);
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
            'Item','Auction', 'open',
            'max',
            'created_at'

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ClientBid_' . date('YmdHis');
    }
}
