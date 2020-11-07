<?php

namespace App\Model\ManyToMany\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactSubSector extends Model
{
    protected $fillable = [
        'contact_id',
        'sub_sector_id'
    ];

    public function contact()
    {
        return $this->belongsTo('App\Model\Contact');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }
}
