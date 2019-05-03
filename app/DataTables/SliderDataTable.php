<?php

namespace App\DataTables;

use App\Model\Slider;
use App\User;
use Yajra\DataTables\Services\DataTable;

class SliderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)// to show the details of the content in the slider
    {
        return datatables($query)
            ->editColumn('image', function ($user) {
                $html='<img src="'.asset('images/slider/'.$user->image).'" style="width:100px; height:100px;">';
                return $html;
            })
            ->addColumn('action', function ($users) {
                return '<a href="'.route('slider.edit',$users->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                           class="glyphicon glyphicon-edit"></i>Edit</a>&nbsp;&nbsp;<a href="'.route('users.destroy',$users->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>'; })
        ->rawColumns([ 'image',  'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Slider $model)
    {
        return $model->newQuery()->select('id', 'title', 'description','image', 'created_at');
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
            'title', 'description','image',
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
        return 'Slider_' . date('YmdHis');
    }
}
