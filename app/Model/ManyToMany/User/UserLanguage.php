<?php

namespace App\Model\ManyToMany\User;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    protected $fillable = [
        'user_id',
        'language_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function language()
    {
        return $this->belongsTo('App\Model\Language');
    }
}
