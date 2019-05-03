<?php

namespace App\DataTables;

use App\User;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;

class AdminDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)//to show the details of the administrators of this system
    {
        //to add ,edit and allow concatenated columns to be filtered in the existing datable
        return datatables($query)
            ->addColumn('Added_By', function ($user) {
                $get=User::find($user->id);//gets the users details

                $admin=User::find($get->added_by);//gets the admin details who added the user
                if($admin==null)
                    $html="Added By Super Admin";
                else
                    $html='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';

                return $html;
            })
            ->addColumn('action', function ($user) {//adds the column action to the datatable
                return '<a href="'.route('users.edit',$user->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('users.destroy',$user->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })

            ->filterColumn('name', function ($query, $keyword) {//making the concatenated column to be filterable

                $keywords = trim($keyword);
                $query->whereRaw("CONCAT(FirstName, Surname) like ?", ["%{$keywords}%"]);//concatenates the users first and surname and
                                                                                        // then searches the with the keyword entered in the datatable

            })
            ->rawColumns(['Added_By', 'action']);//the html elements in the column will not be printed as
                                                //they are instead the element will work as intended
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()->select('id', DB::raw('CONCAT(FirstName," ", Surname ) AS name'), 'email', 'phone_no')
                                ->where('Cstatus','=','Admin');
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
                    ->addAction(['width' => '27%'])
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
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin_' . date('YmdHis');
    }
}
