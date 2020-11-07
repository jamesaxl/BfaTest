<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transporter extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
        'transport_mode',
        'transport_equipment_number',
        'annual_turnover',
        'employees_number',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
