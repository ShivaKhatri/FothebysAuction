<?php

namespace App\DataTables;

use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class LimitCommissionBidDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)//to show the limit of users amount they can bid
    {
        return datatables($query)
            ->addColumn('User_Type', function ($user) {
                $get=User::find($user->id);

                $wow='<b>'.$get->Cstatus.'</b>';

                return $wow;
            })
            ->editColumn('bidLimit', function ($user) {
                $get=User::find($user->id);
                if($get->bidLimit==null){
                    $wow='Limit Not Set';
                }else{
                    $wow='<b>'.$get->bidLimit.'</b>';}

                return $wow;
            })
            ->addColumn('action', function ($users) {
                return '<a href="'.route('users.show',$users->id).'" class="btn btn-sm btn-success" id="show" ><i class="glyphicon glyphicon-eye"></i> Show</a>
                        <a href="'.route('commission.limit',$users->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                           class="glyphicon glyphicon-edit"></i>Change Limit</a>'; })

            ->filterColumn('name', function ($query, $keyword) {

                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(FirstName, Surname) like ?", ["%{$keywords}%"]);

            })
            ->rawColumns([ 'User_Type', 'bidLimit', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select('id', DB::raw('CONCAT(FirstName," ", Surname ) AS name'), 'email', 'phone_no','bidLimit')->where('Cstatus','=','Buyer')->orWhere('Cstatus','=','Both')->where('Astatus','=','verified');

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
            'name',
            'email',
            'phone_no',
            'User_Type',
            'bidLimit',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'LimitCommissionBid_' . date('YmdHis');
    }
}
