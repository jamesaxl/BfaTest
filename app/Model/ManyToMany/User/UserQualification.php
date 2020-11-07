<?php

namespace App\Model\ManyToMany\User;

use Illuminate\Database\Eloquent\Model;

class UserQualification extends Model
{
    protected $fillable = [
        'user_id',
        'qualification_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function qualification()
    {
        return $this->belongsTo('App\Model\Qualification');
    }
}
