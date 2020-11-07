<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $guarded = [];
    
    public function Country()
    {
        return $this->belongsTo('App\Model\Country');
    }
}
