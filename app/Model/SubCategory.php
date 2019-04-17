<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'name', 'description', 'admin_id','category_id'
    ];
    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category','category_id');
    }
    public function item()
    {
        return $this->hasMany('App\Model\Item','subCategory_id');
    }
}
