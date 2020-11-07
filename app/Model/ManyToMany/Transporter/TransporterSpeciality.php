<?php

namespace App\Model\ManyToMany\Transporter;

use Illuminate\Database\Eloquent\Model;

class TransporterSpeciality extends Model
{
    protected $fillable = [
        'transporter_id',
        'speciality_id',
    ];

    public function transporter()
    {
        return $this->belongsTo('App\Model\Transporter');
    }

    public function speciality()
    {
        return $this->belongsTo('App\Model\Speciality');
    }
}
