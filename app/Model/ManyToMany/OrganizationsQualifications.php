<?php

namespace App\Model\ManyToMany;

use Illuminate\Database\Eloquent\Model;

class OrganizationsQualifications extends Model
{
    protected $fillable = [
        'organization_id',
        'qualification_id',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }

    public function qualification()
    {
        return $this->belongsTo('App\Model\Qualification');
    }
}
