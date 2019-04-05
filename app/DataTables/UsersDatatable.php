<?php

namespace App\DataTables;

use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class UsersDatatable extends DataTable
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
            ->addColumn('action', function ($users) {
                return '<a href="'.route('users.edit',$users->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('users.destroy',$users->id).'" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->filterColumn('name', function ($query, $keyword) {

                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(FirstName, Surname) like ?", ["%{$keywords}%"]);

            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select('id', DB::raw('CONCAT(FirstName," ", Surname ) AS name'), 'email', 'phone_no');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
//        $query=User::all();
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->addAction(['width' => '130px'])
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
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
