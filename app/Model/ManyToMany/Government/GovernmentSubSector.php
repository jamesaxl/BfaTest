<?php

namespace App\Model\ManyToMany\Government;

use Illuminate\Database\Eloquent\Model;

class GovernmentSubSector extends Model
{
    protected $fillable = [
        'government_id',
        'sub_sector_id',
    ];

    public function subSector()
    {
        return $this->belongsTo('App\Model\'SubSector');
    }

    public function government()
    {
        return $this->belongsTo('App\Model\Government');
    }
}
