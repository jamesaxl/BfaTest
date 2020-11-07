<?php

namespace App\Model\ManyToMany;

use Illuminate\Database\Eloquent\Model;

class OrganizationsJobs extends Model
{
    protected $fillable = [
        'organization_id',
        'job_id',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }

    public function job()
    {
        return $this->belongsTo('App\Model\Job');
    }
}
