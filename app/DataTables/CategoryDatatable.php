<?php

namespace App\DataTables;

use App\Model\Category;
use Yajra\DataTables\Services\DataTable;

class CategoryDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)//to show the details of the category
    {
        return datatables($query)
            ->addColumn('admin', function ($category) {
                $admin=Category::find($category->id)->admin()->first();
                $wow=null;
                if($admin!=null){
                    $wow='<b>'.$admin->FirstName.' '.$admin->Surname.'</b>';
                }
                return $wow;
            })
            ->addColumn('details', function ($category) {
                $value=Category::find($category->id)->detail()->get();
                $count=count($value);
                $wow='<ol>';
                foreach($value as $get){
                    $wow=$wow.'<li>'.$get->name.'</li>';

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Details Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('SubCategory', function ($category) {
                $value=Category::find($category->id)->subCategory()->get();
                $count=count($value);
                $wow='<ol>';
                foreach($value as $get){
                    $wow=$wow.'<li>'.$get->name.'</li>';

                }
                $wow=$wow.'</ol>';
//                dd($sec);
                if($count==0){
                    $wow='<b>No Sub Categories Assigned</b>';
                    return $wow;
                }
//                dd($wow);
                return $wow;
            })
            ->addColumn('action', function ($category) {
                return '<a href="'.route('category.edit',$category->id).'" class="btn btn-sm btn-primary" style="margin:3px"><i
                                                    class="glyphicon glyphicon-edit"></i> Edit</a></a>&nbsp;&nbsp;<a href="'.route('category.destroy',$category->id).'" class="btn btn-sm btn-danger" id="delete" ><i class="glyphicon glyphicon-remove"></i> Delete</a>';
            })
            ->rawColumns(['admin', 'details','SubCategory', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery()->select('id', 'name', 'description');
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
            'admin',
            'details',
            'SubCategory'
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Category_' . date('YmdHis');
    }
}
