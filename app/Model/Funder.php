<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Funder extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'employees_number',
        'available_amount',
        'funds_sources',
        'type',
        'sub_type',
        'fund_manager',
        'fund_nature',
        'sustainability',
        'adaptation',
        'recipients_type',
        'eligibility_criteria',
        'decision_making_information',
        'financial_instrument',
        'monitoring',
        'application_timeframe',
        'key_inputs_required_throughout_the_process',
        'further_application_support_sources',
        'recent_funded_projects_examples',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
