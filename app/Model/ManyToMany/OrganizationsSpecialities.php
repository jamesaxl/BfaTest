<?php

namespace App\Model\ManyToMany;

use Illuminate\Database\Eloquent\Model;

class OrganizationsSpecialities extends Model
{
    protected $fillable = [
        'organization_id',
        'speciality_id',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }

    public function speciality()
    {
        return $this->belongsTo('App\Model\Speciality');
    }
}
