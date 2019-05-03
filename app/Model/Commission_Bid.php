<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Commission_Bid extends Model
{
    //the attributes that can be filled in this table
    protected $fillable = [
        'auction_id', 'client_id', 'item_id','open','max',
    ];
    public function auction()
    {
        return $this->belongsTo('App\Model\Auction','auction_id');
    }

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
