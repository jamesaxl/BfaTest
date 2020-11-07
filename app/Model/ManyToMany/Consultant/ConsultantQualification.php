<?php

namespace App\Model\ManyToMany\Consultant;

use Illuminate\Database\Eloquent\Model;

class ConsultantQualification extends Model
{
    protected $fillable = [
        'consultant_id',
        'qualification_id',
    ];

    public function consultant()
    {
        return $this->belongsTo('App\Model\Consultant');
    }

    public function qualification()
    {
        return $this->belongsTo('App\Model\Qualification');
    }
}
