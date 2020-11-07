<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $guarded = [];

    public function subSectors()
    {
        return $this->hasMany('App\Model\SubSector');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_sectors');
    }

    public function userSectors()
    {
        return $this->hasMany('App\Model\ManyToMany\User\UserSector');
    }

}
