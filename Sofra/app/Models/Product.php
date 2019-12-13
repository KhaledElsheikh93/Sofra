<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model 
{

    protected $table = 'products';
    public $timestamps = true;
    protected $fillable = array('name', 'description', 'price', 'offering_price', 'duration', 'restaurant_id');

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }


    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }


    // public function getClientOriginalName()
    // {
    //     return $this->image;
    // }

}