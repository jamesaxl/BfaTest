<?php

namespace App\Model\ManyToMany\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactSector extends Model
{
    protected $fillable = [
        'contact_id',
        'sector_id'
    ];

    public function contact()
    {
        return $this->belongsTo('App\Model\Contact');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }
}
