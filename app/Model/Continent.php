<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    protected $guarded = [];
    
    public function countries()
    {
        return $this->hasMany('App\Model\Country');
    }

    public function projects()
    {
        return $this->hasMany('App\Model\Project');
    }
}
