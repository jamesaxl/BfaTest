<?php

namespace App\Model\ManyToMany\Company;

use Illuminate\Database\Eloquent\Model;

class CompanySubSector extends Model
{
    protected $fillable = [
        'company_id',
        'sub_sector_id',
    ];

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }
}
