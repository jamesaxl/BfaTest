<?php

namespace App\Model\ManyToMany\Consultant;

use Illuminate\Database\Eloquent\Model;

class ConsultantSector extends Model
{
    protected $fillable = [
        'consultant_id',
        'sector_id',
    ];

    public function consultant()
    {
        return $this->belongsTo('App\Model\Consultant');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }
}
