<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User', 'apply_by_id');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

    public function organizations()
    {
        return $this->belongsToMany('App\Model\Organization', 'organizations_jobs');
    }

    public function organizationsJobs()
    {
        return $this->hasMany('App\Model\ManyToMany\OrganizationsJobs');
    }
}
