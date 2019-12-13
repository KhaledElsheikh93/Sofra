<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model 
{

    protected $table = 'tokens';
    public $timestamps = true;
    protected $fillable = ['token' , 'tokenable_type' , 'tokenable_id'];

    public function tokenable()
    {
        return $this->morphTo();
    }


}