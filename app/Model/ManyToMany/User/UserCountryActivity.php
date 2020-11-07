<?php

namespace App\Model\ManyToMany\User;

use Illuminate\Database\Eloquent\Model;

class UserCountryActivity extends Model
{
    protected $fillable = [
        'user_id',
        'country_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }
}
