<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    protected $fillable = [
        'name', 'description', 'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo('App\User','admin_id');
    }
}

