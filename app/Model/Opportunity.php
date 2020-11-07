<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    protected $guarded = [
        'add_by_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'add_by_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Model\Project');
    }

    public function producer()
    {
        return $this->belongsTo('App\Model\Producer');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
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

    public function organizations()
    {
        return $this->belongsToMany('App\Model\Organization', 'organizations_opportunities');
    }

    public function organizationsOpportunities()
    {
        return $this->hasMany('App\Model\ManyToMany\OrganizationsOpportunities');
    }

    public static function validHash($link_acquisition)
    {
        $hash = md5($link_acquisition);
        if (Opportunity::where('hash', $hash)->first()) {
            return false;
        }
        return $hash;
    }

    public static function validHashUpdate($link_acquisition, $id)
    {
        $hash = md5($link_acquisition);
        if (Opportunity::where('hash', $hash)->where('id', '!=', $id)->first()) {
            return false;
        }
        return $hash;
    }
}
