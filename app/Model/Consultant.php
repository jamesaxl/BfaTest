<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Consultant extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'monthly_salary_level',
        'reference',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
