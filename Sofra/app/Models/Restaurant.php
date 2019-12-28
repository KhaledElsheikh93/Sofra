<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model 
{

    protected $table = 'restaurants';
    public $timestamps = true;
    protected $fillable = array( 'pin_code','name', 'email', 'phone','restaurant_payment', 'password', 'district_id', 'delivery_charge', 'minimum_order', 'contact_phone', 'whats', 'category_id','state','app_commission');
    protected $hidden = array('password', 'api_token', 'pin_code');
    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'tokenable');
    }

    public function notifications()
    {
        return $this->morphMany('App\Models\Notification', 'notifiable');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function getTotalCommissionsAttribute()
    {
        $commissions = $this->orders()->where('state','delivered')->sum('commission');
        return $commissions;
    }

    public function getTotalPaymentsAttribute()
    {
        $payments = $this->payments()->sum('paid');
        return $payments;
    }

}