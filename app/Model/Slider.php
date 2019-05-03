<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{//the attributes that can be filled in this table
    protected $fillable = [
        'title', 'description', 'image'
    ];


}
