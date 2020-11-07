<?php

namespace App\Model\ManyToMany\Contact;

use Illuminate\Database\Eloquent\Model;

class ContactQualification extends Model
{
    protected $fillable = [
        'contact_id',
        'qualification_id'
    ];

    public function contact()
    {
        return $this->belongsTo('App\Model\Contact');
    }

    public function qualification()
    {
        return $this->belongsTo('App\Model\Qualification');
    }
}
