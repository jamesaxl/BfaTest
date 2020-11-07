<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FirmConsultant extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'annual_turnover',
        'reference',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
