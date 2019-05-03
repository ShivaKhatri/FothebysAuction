<?php

namespace App\DataTables;

use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class verifiedUsersDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)//to show the details of verified users
    {
        return datatables($query)
            ->addColumn('Added_By', function ($user) {
                $get=User::find($user->id);

                $admin=User::find($get->added_by);
                if($admin==null){
                    $wow='<b> Added by super admin</b>';

                }
                else
                $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';

                return $wow;
            })

            ->addColumn('Verified_By', function ($user) {
                $get=User::find($user->id);

                $admin=User::find($get->verified_by);
                if($admin==null){
                    $wow='<b> Verified by super admin</b>';

                }
                else
                $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';

                return $wow;
            })

            ->addColumn('action', function ($user) {
                return '<a href="'.route('users.edit',$user->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('users.destroy',$user->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>&nbsp;&nbsp;<a href="'.route('users.show',$user->id).'" class="btn btn-sm btn-success" id="show" ><i class="glyphicon glyphicon-eye"></i> Show</a>';
            })

            ->filterColumn('name', function ($query, $keyword) {

                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(FirstName, Surname) like ?", ["%{$keywords}%"]);

            })
            ->rawColumns(['Added_By','Verified_By', 'action']);
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
            'phone_no')->where('Astatus','=','verified');
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
                    ->addAction(['width' => '25%'])
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
            'Added_By',
            'Verified_By'

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'verifiedUsers_' . date('YmdHis');
    }
}
