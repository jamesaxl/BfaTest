<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KpiIndicator extends Model
{

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

    public function years ()
    {
        return $this->hasMany('App\Model\Years');
    }
}
