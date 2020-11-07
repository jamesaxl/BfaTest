<?php

namespace App\Model\ManyToMany\Consultant;

use Illuminate\Database\Eloquent\Model;

class ConsultantSubSector extends Model
{
    protected $fillable = [
        'consultant_id',
        'sub_sector_id',
    ];

    public function consultant()
    {
        return $this->belongsTo('App\Model\Consultant');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }
}
