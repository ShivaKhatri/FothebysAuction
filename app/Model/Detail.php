<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{//the attributes that can be filled in this table
    protected $fillable = [
        'name', 'description', 'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }

    //the one to many relation of this model
    public function category()
    {
        return $this->belongsTo('App\Model\Category','category_id');
    }

    public function detailValue()
    {
        return $this->hasMany('App\Model\Detail_value','detail_id');
    }
}
