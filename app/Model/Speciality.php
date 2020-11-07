<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
    protected $guarded = [];

    public function qualifications()
    {
        return $this->hasMany('App\Model\Qualification');
    }
}
