<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'brands_sold',
        'annual_turnover',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
