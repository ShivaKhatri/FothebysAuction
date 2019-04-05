<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'nameArtist',
        'Piece_Title',
        'lotReferenceNumber',
        'year',
        'classification_id',
        'category_id',
        'description',
        'estimated_price_from',
        'estimated_price_to',
        'reserved_price',
        'client_id',
        'authenticated',
        'provenance_details',
        'customer_agreement',
        'expert_id',
        'additional_notes',
        'signed_date'
    ];
    public function admin()
    {
        return $this->belongsTo('App\User','expert_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category','category_id');
    }
    public function classification()
    {
        return $this->belongsTo('App\Model\Classification','classification_id');
    }
    public function client()
    {
        return $this->belongsTo('App\User','client_id');
    }
    public function image()
    {
        return $this->hasMany('App\Model\Image','item_id');
    }
}
