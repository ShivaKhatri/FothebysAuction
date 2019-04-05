<?php

namespace App\DataTables;

use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class UnVerifiedDatatable extends DataTable
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
            ->addColumn('Added_By', function ($user) {
                $get=User::find($user->id);

                $admin=User::find($get->added_by);
                $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';

                return $wow;
            })

            ->addColumn('UnVerified_By', function ($user) {
                $get=User::find($user->id);

                $admin=User::find($get->verified_by);
                $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';

                return $wow;
            })

            ->addColumn('action', function ($user) {
                return '<a href="'.route('users.edit',$user->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('users.destroy',$user->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })

            ->filterColumn('name', function ($query, $keyword) {

                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(FirstName, Surname) like ?", ["%{$keywords}%"]);

            })
            ->rawColumns(['Added_By','UnVerified_By', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select('id', DB::raw('CONCAT(FirstName," ", Surname ) AS name'),
            'email',
            'phone_no',  'created_at', 'updated_at')->where('Astatus','=','UnVerified');
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
                    ->addAction(['width' => '120px'])
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
            'Added_By',
            'UnVerified_By',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'UnVerified_' . date('YmdHis');
    }
}
