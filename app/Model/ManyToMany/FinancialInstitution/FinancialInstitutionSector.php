<?php

namespace App\Model\ManyToMany\FinancialInstitution;

use Illuminate\Database\Eloquent\Model;

class FinancialInstitutionSector extends Model
{
    protected $fillable = [
        'financial_institution_id',
        'sector_id',
    ];

    public function financialInstitution()
    {
        return $this->belongsTo('App\Model\FinancialInstitution');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

}
