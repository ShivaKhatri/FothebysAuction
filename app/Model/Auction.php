<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{//the attributes that can be filled in this table
    protected $fillable = [
        'themeName', 'description', 'admin_id','themeValue','location','session','date',
    ];

    //the one to many relation of this model
    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category','themeValue');
    }

    public function detailValue()
    {
        return $this->hasMany('App\Model\Detail_value','detail_id');
    }
    public function item()
    {
        return $this->hasMany('App\Model\Item','auction_id');
    }
}
