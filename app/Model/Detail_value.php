<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detail_value extends Model
{//the attributes that can be filled in this table
    protected $fillable = [
        'name', 'description', 'admin_id'
    ];
    //the one to many relation of this model
    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    //the one to many relation of this model
    public function detailValue()
    {
        return $this->belongsTo('App\Model\Detail','detail_id');
    }
}
