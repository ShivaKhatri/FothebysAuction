<?php

namespace App\DataTables;

use App\Model\Commission_Bid;
use App\Model\Item;
use App\User;
use Yajra\DataTables\Services\DataTable;

class AuctionedDataTable extends DataTable
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
            ->addColumn('action', function ($item) {
                $auction=Item::find($item->id)->auction()->first();
                $auction_date=$auction->auction_date;
                $today=date('Y-m-d');
                if($today==$auction_date||$auction_date<$today){
                    return '<a href="'.route('item.show',$item->id).'" class="btn btn-sm btn-success" style="margin:3px">
                         Show</a><a href="'.route('auctioned.auctioneer',$item->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Add Details</a><a href="'.route('auctioned.edit',$item->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit Details</a>';
                }
                return '<a href="'.route('item.show',$item->id).'" class="btn btn-sm btn-success" style="margin:3px">
                         Show</a>';

            })
            ->addColumn('Lot no', function ($item) {

                $Dname=Item::find($item->id)->auction()->first();
                if($Dname==null){
                    $wow='<strong>In process to be assigned to a auction</strong>';

                }
                else
                    $wow=$Dname->lotNumber;
//                dd($wow);
                return $wow;
            })
            ->addColumn('bid', function ($item) {
                $html='
                <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">Client No</th>
                      <th scope="col">Open</th>
                      <th scope="col">Max</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                     ';
                $Dname=Item::find($item->id)->bid()->get();

                foreach ($Dname as $value){
                    $client=Commission_Bid::find($value->id)->client()->first();
                    $html=$html.'<th scope="row">'.$client->id.'</th>
                                  <td>'.$value->open.'</td>
                                  <td>'.$value->max.'</td>';
                }
                $html=$html.'</tr>
                              </tbody>
                            </table>';
                return $html;
            })
            ->addColumn('sold_to', function($item) {
                if($item->sold_to_id==NULL){
                    return 'Not Sold';

                }
                else{
                    return  $item->sold_to_id ;

                }
            })
            ->editColumn('sold', function($item) {
                if($item->sold==NULL){
                    return 'Not Sold';

                }
                else{
                    return  $item->sold ;

                }
            })
            ->editColumn('auctioneer_comment', function($item) {
                if($item->auctioneer_comment==NULL){
                    return 'Not Comments';

                }
                else{
                    return  $item->auctioneer_comment ;

                }
            })
            ->rawColumns(['bid','sold_to','Lot no','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Item $model)
    {
        return $model->newQuery()->select( 'id','Piece_Title','reservePrice', 'sold','auctioneer_comment')->where('approved','=','allowed')->where('auction_id','!=',null);
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
            'Lot no','Piece_Title','bid','sold_to',
            'sold', 'reservePrice','auctioneer_comment'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Auctioned_' . date('YmdHis');
    }
}
