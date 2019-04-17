<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Detail_value extends Model
{
    protected $fillable = [
        'name', 'description', 'admin_id'
    ];

    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
    public function detailValue()
    {
        return $this->belongsTo('App\Model\Detail','detail_id');
    }
}
