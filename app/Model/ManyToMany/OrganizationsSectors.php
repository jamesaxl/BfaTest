<?php

namespace App\Model\ManyToMany;

use Illuminate\Database\Eloquent\Model;

class OrganizationsSectors extends Model
{
    protected $fillable = [
        'organization_id',
        'sector_id',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }
}
