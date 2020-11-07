protected $fillable = [<?php

namespace App\Model\ManyToMany\Government;

use Illuminate\Database\Eloquent\Model;

class GovernmentSector extends Model
{
    protected $fillable = [
        'government_id',
        'sector_id',
    ];

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

    public function government()
    {
        return $this->belongsTo('App\Model\Government');
    }
}
