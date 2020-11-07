<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    public function opportunities()
    {
        return $this->hasMany('App\Model\Opportunity');
    }
}
