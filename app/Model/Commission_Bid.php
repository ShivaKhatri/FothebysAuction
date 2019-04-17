<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Commission_Bid extends Model
{
    protected $fillable = [
        'auction_id', 'client_id', 'item_id','open','max',
    ];
    public function auction()
    {
        return $this->belongsTo('App\Model\Auction','auction_id');
    }
    public function client()
    {
        return $this->belongsTo('App\User','client_id');
    }
    public function item()
    {
        return $this->belongsTo('App\Model\Item','item_id');
    }

}
