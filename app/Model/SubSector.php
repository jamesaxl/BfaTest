<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SubSector extends Model
{
    protected $guarded = [];

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_sectors');
    }

    public function userSubSectors()
    {
        return $this->hasMany('App\Model\ManyToMany\User\UserSubSector');
    }
}
