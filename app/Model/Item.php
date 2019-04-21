<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'artists',
        'Piece_Title',
        'lotReferenceNumber',
        'lotNumber',
        'from',
        'to',
        'classification_id',
        'category_id',
        'subCategory_id',
        'description',
        'estimated_price_from',
        'estimated_price_to',
        'sold_to_id',
        'sold',
        'reservePrice',
        'client_id',
        'authenticated',
        'provenance_details',
        'customer_agreement',
        'expert_id',
        'auction_id',
        'approved',
        'frontImage',
        'backImage',
        'expert_name',
        'lastNumber',
        'additional_notes',
        'signed_date',
        'auctioneer_comment'
    ];
    public function admin()
    {
        return $this->belongsTo('App\User','expert_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Model\Category','category_id');
    }
    public function subCategory()
    {
        return $this->belongsTo('App\Model\SubCategory','category_id');
    }
    public function classification()
    {
        return $this->belongsTo('App\Model\Classification','classification_id');
    }
    public function sold()
    {
        return $this->belongsTo('App\User','sold_to_id');
    }
    public function detailValue()
    {
        return $this->belongsToMany('App\Model\Detail_value','detail_item_value','item_id','detail_value_id');
    }
    public function client()
    {
        return $this->belongsTo('App\User','client_id');
    }
    public function auction()
    {
        return $this->belongsTo('App\Model\Auction','auction_id');
    }
    public function image()
    {
        return $this->hasMany('App\Model\Image','item_id');
    }
    public function bid()
    {
        return $this->hasMany('App\Model\Commission_Bid','item_id');
    }
    public function income()
    {
        return $this->hasMany('App\Model\Income','item_id');
    }
}
