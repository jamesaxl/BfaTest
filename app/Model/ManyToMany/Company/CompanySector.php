<?php

namespace App\Model\ManyToMany\Company;

use Illuminate\Database\Eloquent\Model;

class CompanySector extends Model
{

    protected $fillable = [
        'company_id',
        'sector_id',
    ];

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

}
