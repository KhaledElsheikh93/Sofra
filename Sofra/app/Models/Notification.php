<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model 
{

    protected $table = 'notifications';
    protected $fillable = array('title', 'content');
    public $timestamps = true;

    public function client()
    {
        return $this->morphTo();
    }

    public function restaurant()
    {
        return $this->morphTo();
    }

}