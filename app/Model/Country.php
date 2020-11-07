<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $guarded = [];

    public function cities()
    {
        return $this->hasMany('App\Model\City');
    }

    public function continent()
    {
        return $this->belongsTo('App\Model\Continent');
    }

    public function medias()
    {
        return $this->hasMany('App\Model\Media');
    }

}
