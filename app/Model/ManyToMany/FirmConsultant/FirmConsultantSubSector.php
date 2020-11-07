<?php

namespace App\Model\ManyToMany\FirmConsultant;

use Illuminate\Database\Eloquent\Model;

class FirmConsultantSubSector extends Model
{
    protected $fillable = [
        'firm_consultant_id',
        'sub_sector_id',
    ];

    public function firmConsultant()
    {
        return $this->belongsTo('App\Model\FirmConsultant');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }
}
