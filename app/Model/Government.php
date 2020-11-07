<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'country_info',
        'president_minister',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
