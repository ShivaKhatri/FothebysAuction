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
    public function dataTable($query)// to show the details of the users
    {
        return datatables($query)
            ->addColumn('action', function ($users) {
                $verify=User::find($users->id)->Astatus;
                if($verify=="verified") {
                    return '<a href="'.route('users.show',$users->id).'" class="btn btn-sm btn-success" id="show" ><i class="glyphicon glyphicon-eye"></i> Show</a>
                        <a href="' . route('users.edit', $users->id) . '" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="' . route('users.destroy', $users->id) . '" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';
                }
                else{
                    return '<a href="' . route('users.verify', $users->id) . '" class="btn btn-sm btn-success" style="margin:3px"><i
                                                    class="glyphicon glyphicon-successt"></i> Verify</a><a href="' . route('users.edit', $users->id) . '" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="' . route('users.destroy', $users->id) . '" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i> Delete</a>';

                }
            })
            ->addColumn('User_Type', function ($users) {
                $user=User::find($users->id);
                $type=$user->Cstatus;
                return $type;
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
            'User_Type',
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
