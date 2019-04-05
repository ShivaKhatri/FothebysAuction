<?php

namespace App\DataTables;

use App\Model\Classification;
//use App\Classification;
use Yajra\DataTables\Services\DataTable;

class ClassificationDatatable extends DataTable
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
            ->addColumn('Added_By', function ($classification) {
                $admin=Classification::find($classification->id)->admin()->first();
                $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';
                return $wow;
            })
            ->addColumn('action', function ($category) {
                return '<a href="'.route('classification.edit',$category->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.route('classification.destroy',$category->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->rawColumns(['Added_By', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Classification $model)
    {
        return $model->newQuery()->select('id', 'name', 'description', 'created_at', 'updated_at');
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
            'description',
            'Added_By',
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
        return 'Classification_' . date('YmdHis');
    }
}
