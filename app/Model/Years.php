<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Years extends Model
{
    public function kpiIndicator ()
    {
        return $this->belongsTo('App\Model\KpiIndicator');
    }
}
