<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{//the attributes that can be filled in this table
    protected $fillable = [
        'item_id', 'client_id', 'remove_price','commission'
    ];
    //the one to many relation of this model
    public function client()
    {
        return $this->belongsTo('App\User','client_id');
    }
    public function item()
    {
        return $this->belongsTo('App\Model\Item','item_id');
    }
}
