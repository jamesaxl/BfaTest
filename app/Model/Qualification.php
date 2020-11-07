<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    protected $guarded = [];
    
    public function users()
    {
        return $this->belongsToMany('App\User', 'user_sectors');
    }

    public function userQualification()
    {
        return $this->hasMany('App\Model\ManyToMany\User\UserQualification');
    }

    public function speciality()
    {
        return $this->belongsTo('App\Model\Speciality');
    }
}
