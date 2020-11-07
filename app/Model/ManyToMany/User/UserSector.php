<?php

namespace App\Model\ManyToMany\User;

use Illuminate\Database\Eloquent\Model;

class UserSector extends Model
{
    protected $fillable = [
        'user_id',
        'sector_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }
}
