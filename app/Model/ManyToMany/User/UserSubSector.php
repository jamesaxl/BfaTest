<?php

namespace App\Model\ManyToMany\User;

use Illuminate\Database\Eloquent\Model;

class UserSubSector extends Model
{
    protected $fillable = [
        'user_id',
        'sub_sector_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }
}
