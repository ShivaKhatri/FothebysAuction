<?php

namespace App\DataTables;

use App\Model\Detail;
use Yajra\DataTables\Services\DataTable;

class DetailDatatable extends DataTable
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
            ->addColumn('Added_By', function ($detail) {
                $admin=Detail::find($detail->id)->admin()->first();
                $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';
                return $wow;
            })
            ->addColumn('category', function ($detail) {
                $admin=Detail::find($detail->id)->category()->first();
                $wow='<b>'.$admin->name.'</b>';
                return $wow;
            })
            ->addColumn('Values', function ($detail) {
                $value=Detail::find($detail->id)->detailValue()->get();
                $Dname=Detail::find($detail->id);
                $count=count($value);
                $wow='<ol>';
                foreach($value as $get){
                    if($get->name=="null"){
                        $wow=$wow.'<li>'.$Dname->name.'</li>';

                    }
                    else{
                        $wow=$wow.'<li>'.$get->name.'</li>';

                    }

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Values Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('action', function ($detail) {
                return '<a href="'.route('detail.edit',$detail->id).'" class="btn btn-sm btn-primary" style="margin:3px">
                        <i class="glyphicon glyphicon-edit"></i> Edit</a>&nbsp;&nbsp;<a href="'.route('detail.destroy',$detail->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->rawColumns(['Added_By','category', 'Values','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Detail $model)
    {
        return $model->newQuery()->select('id', 'name', 'description',  'created_at');
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
                    ->addAction(['width' => '20%'])
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
            'category',
            'Values',
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
        return 'Detail_' . date('YmdHis');
    }
}
