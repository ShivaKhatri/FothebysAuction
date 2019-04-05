<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detail_value extends Model
{
    protected $fillable = [
        'name', 'description', 'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function detailValue()
    {
        return $this->belongsToMany('App\Model\Detail','detail_detail_value','detail_value_id','detail_id');
    }
}
