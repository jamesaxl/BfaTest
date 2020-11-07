<?php

namespace App\Model\ManyToMany\FirmConsultant;

use Illuminate\Database\Eloquent\Model;

class FirmConsultantSpeciality extends Model
{
    protected $fillable = [
        'firm_consultant_id',
        'speciality_id',
    ];

    public function firmConsultant()
    {
        return $this->belongsTo('App\Model\FirmConsultant');
    }

    public function speciality()
    {
        return $this->belongsTo('App\Model\Speciality');
    }
}
