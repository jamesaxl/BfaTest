<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }

    public function sectors()
    {
        return $this->belongsToMany('App\Model\Sector', 'contact_sectors');
    }

    public function contactSectors()
    {
        return $this->hasMany('App\Model\ManyToMany\Contact\ContactSector');
    }

    public function subSectors()
    {
        return $this->belongsToMany('App\Model\SubSector', 'contact_sub_sectors');
    }

    public function contactSubSectors()
    {
        return $this->hasMany('App\Model\ManyToMany\Contact\ContactSubSector');
    }

    public function qualifications()
    {
        return $this->belongsToMany('App\Model\Qualification', 'contact_qualifications');
    }

    public function contactQualifications()
    {
        return $this->hasMany('App\Model\ManyToMany\Contact\ContactQualification');
    }

    public function nationality()
    {
        return $this->belongsTo('App\Model\Country', 'nationality_id');
    }

    public function accountType()
    {
        return $this->belongsTo('App\Model\AccountType');
    }

    public function accountSubType()
    {
        return $this->belongsTo('App\Model\AccountSubType');
    }
}
