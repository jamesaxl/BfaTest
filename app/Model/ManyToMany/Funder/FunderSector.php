<?php

namespace App\Model\ManyToMany\Funder;

use Illuminate\Database\Eloquent\Model;

class FunderSector extends Model
{
    protected $fillable = [
        'funder_id',
        'sector_id',
    ];
    public function funder()
    {
        return $this->belongsTo('App\Model\Funder');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }
}
