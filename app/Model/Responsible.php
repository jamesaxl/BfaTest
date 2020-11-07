<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Responsible extends Model
{
    protected $fillable = [
        'user_id',
        'organization_id',
    ];

    public function user()
    {
        $this->belongsTo('App\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
