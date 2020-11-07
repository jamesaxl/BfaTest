<?php

namespace App\Model\ManyToMany\FirmConsultant;

use Illuminate\Database\Eloquent\Model;

class FirmConsultantSector extends Model
{
    protected $fillable = [
        'firm_consultant_id',
        'sector_id',
    ];

    public function firmConsultant()
    {
        return $this->belongsTo('App\Model\FirmConsultant');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }
}
