<?php

namespace App\Model\ManyToMany;

use Illuminate\Database\Eloquent\Model;

class OrganizationsSubSectors extends Model
{
    protected $fillable = [
        'organization_id',
        'sub_sector_id',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }
}
