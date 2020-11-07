<?php

namespace App\Model\ManyToMany\FirmConsultant;

use Illuminate\Database\Eloquent\Model;

class FirmConsultantQualification extends Model
{
    protected $fillable = [
        'firm_consultant_id',
        'qualification_id',
    ];

    public function firmConsultant()
    {
        return $this->belongsTo('App\Model\FirmConsultant');
    }

    public function qualification()
    {
        return $this->belongsTo('App\Model\Qualification');
    }
}
