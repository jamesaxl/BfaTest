<?php

namespace App\Model\ManyToMany\Company;

use Illuminate\Database\Eloquent\Model;

class CompanySpeciality extends Model
{
    protected $fillable = [
        'company_id',
        'speciality_id',
    ];

    public function company()
    {
        return $this->belongsTo('App\Model\Company');
    }

    public function speciality()
    {
        return $this->belongsTo('App\Model\Speciality');
    }
}
