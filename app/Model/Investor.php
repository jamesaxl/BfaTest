<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'fund_size',
        'number_employees',
        'recent_funded_projects_examples',
        'fund_manager_trustee',
        'amount_available',
        'type_recipients',
        'eligibility_criteria',
        'decision_making',
        'information',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
