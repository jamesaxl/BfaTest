<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SectorInfo extends Model
{
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }
}
