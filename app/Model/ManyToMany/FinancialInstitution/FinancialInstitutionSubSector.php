<?php

namespace App\Model\ManyToMany\FinancialInstitution;

use Illuminate\Database\Eloquent\Model;

class FinancialInstitutionSubSector extends Model
{
    protected $fillable = [
        'financial_institution_id',
        'sub_sector_id',
    ];

    public function financialInstitution()
    {
        return $this->belongsTo('App\Model\FinancialInstitution');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }
}
