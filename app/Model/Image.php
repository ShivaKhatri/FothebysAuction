<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //the attributes that can be filled in this table
    protected $fillable = [
        'name', 'image', 'admin_id','item_id'
    ];
    //the one to many relation of this model
    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function item()
    {
        return $this->belongsTo('App\Model\Item','item_id');
    }
}
