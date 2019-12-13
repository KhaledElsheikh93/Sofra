<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Order extends Model 
{

    protected $table = 'orders';
    public $timestamps = true;
    protected $fillable = array('client_id', 'restaurant_id', 'amount', 'total', 'cost', 'net', 'state');

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('price','amount','notes');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}