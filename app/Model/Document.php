<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }

    public function documentType()
    {
        return $this->belongsTo('App\Model\DocumentType');
    }

    public function documentSubType()
    {
        return $this->belongsTo('App\Model\DocumentSubType');
    }
}
