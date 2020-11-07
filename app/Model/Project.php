<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [
        'add_by_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'add_by_id');
    }

    public function opportunities()
    {
        return $this->hasMany('App\Model\Opportunity');
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

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }

    public static function validHash($link_project)
    {
        $hash = md5($link_project);
        if (Project::where('hash', $hash)->first()) {
            return false;
        }
        return $hash;
    }

    public static function validHashUpdate($link_project, $id)
    {
        $hash = md5($link_project);
        if (Project::where('hash', $hash)->where('id', '!=', $id)->first()) {
            return false;
        }
        return $hash;
    }
}
