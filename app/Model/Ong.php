<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ong extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function continent()
    {
        return $this->belongsTo('App\Model\Continent');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }

    public function ongType()
    {
        return $this->belongsTo('App\Model\AccountSubType', 'ong_type_id');
    }
}
