<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
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

    public function sub_sector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }

    public function project()
    {
        return $this->belongsTo('App\Model\Project');
    }
}
