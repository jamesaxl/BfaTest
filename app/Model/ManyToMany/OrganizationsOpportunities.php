<?php

namespace App\Model\ManyToMany;

use Illuminate\Database\Eloquent\Model;

class OrganizationsOpportunities extends Model
{
    protected $fillable = [
        'organization_id',
        'opportunity_id',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }

    public function opportunity()
    {
        return $this->belongsTo('App\Model\Opportunity');
    }
}
