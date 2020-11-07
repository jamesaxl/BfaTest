<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'id',
        'organization_id',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
