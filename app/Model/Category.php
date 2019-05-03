<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{//the attributes that can be filled in this table
    //the one to many relation of this model
    protected $fillable = [
        'name', 'description', 'admin_id',
    ];

    //the one to many relation of this model
    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function item()
    {
        return $this->hasMany('App\Model\Item','category_id');
    }
    //the one to many relation of this model
    public function detail()
    {
        return $this->hasMany('App\Model\Detail','category_id');
    }
    public function subCategory()
    {
        return $this->hasMany('App\Model\SubCategory','category_id');
    }
}
