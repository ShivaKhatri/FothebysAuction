<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'name', 'description', 'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category','category_id');
    }

    public function detailValue()
    {
        return $this->belongsToMany('App\Model\Detail_value','detail_detail_value','detail_id','detail_value_id');
    }
}
