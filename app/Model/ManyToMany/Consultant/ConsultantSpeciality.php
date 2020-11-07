<?php

namespace App\Model\ManyToMany\Consultant;

use Illuminate\Database\Eloquent\Model;

class ConsultantSpeciality extends Model
{
    protected $fillable = [
        'consultant_id',
        'speciality_id',
    ];

    public function consultant()
    {
        return $this->belongsTo('App\Model\Consultant');
    }

    public function speciality()
    {
        return $this->belongsTo('App\Model\Speciality');
    }
}
