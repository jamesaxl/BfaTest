<?php

namespace App\Model\ManyToMany\Government;

use Illuminate\Database\Eloquent\Model;

class GovernmentQualification extends Model
{
    protected $fillable = [
        'government_id',
        'qualification_id',
    ];

    public function qualification()
    {
        return $this->belongsTo('App\Model\Qualification');
    }

    public function government()
    {
        return $this->belongsTo('App\Model\Government');
    }
}
