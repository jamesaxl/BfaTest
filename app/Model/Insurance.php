<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'mother_group',
        'intervention_industries',
        'employees_number',
        'assets',
        'revenue',
        'net_premium_writen',
        'market_cap',
        'pe_ratio',
        'president_name',
        'agency_boss',
        'document',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
