<?php

namespace App\DataTables;

use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class SellersDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)//to show the details of the sellers details
    {       return datatables($query)
        ->addColumn('verified_by', function ($user) {
            $get=User::find($user->id);

            $admin=User::find($get->verified_by);
            $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';

            return $wow;
        })
        ->addColumn('Added_By', function ($user) {
            $get=User::find($user->id);

            $admin=User::find($get->added_by);
            $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';

            return $wow;
        })
        ->addColumn('action', function ($users) {
            return '<a href="'.route('users.edit',$users->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('users.destroy',$users->id).'" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
        })

        ->filterColumn('name', function ($query, $keyword) {

            $keywords = trim($keyword);
            $query->whereRaw("CONCAT(FirstName, Surname) like ?", ["%{$keywords}%"]);

        })
        ->rawColumns(['Added_By','verified_by', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select('id', DB::raw('CONCAT(FirstName," ", Surname ) AS name'), 'email', 'phone_no', 'bank_no', 'created_at', 'updated_at')->where('Cstatus','=','Buyer')->where('Astatus','=','verified');

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
            'id',
            'name',
            'email',
            'phone_no',
            'bank_no',
            'verified_by',
            'created_at',
            'updated_at'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Sellers_' . date('YmdHis');
    }
}
