<?php

namespace App\DataTables;

use App\Model\SubCategory;
use App\User;
use Yajra\DataTables\Services\DataTable;

class SubCategoryDatatable extends DataTable
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
            ->addColumn('admin', function ($category) {
                $admin=SubCategory::find($category->id)->admin()->first();
                $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';
                return $wow;
            })
            ->addColumn('category', function ($category) {
                $admin=SubCategory::find($category->id)->category()->first();
                $wow='<b>'.$admin->name.'</b>';
                return $wow;
            })
            ->addColumn('action', function ($category) {
                return '<a href="'.route('subCategory.edit',$category->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('subCategory.destroy',$category->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->rawColumns(['admin', 'category', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SubCategory $model)
    {
        return $model->newQuery()->select('id', 'name', 'description', 'created_at');
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
            'category',
            'description',
            'admin',
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
        return 'SubCategory_' . date('YmdHis');
    }
}
