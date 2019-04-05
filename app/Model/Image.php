<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'name', 'image', 'admin_id','item_id'
    ];

    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function item()
    {
        return $this->belongsTo('App\Model\Item','item_id');
    }
}
