<?php

namespace App\Model\ManyToMany\Consultant;

use Illuminate\Database\Eloquent\Model;

class ConsultantOpportunity extends Model
{
    protected $fillable = [
        'consultant_id',
        'opportunity_id',
    ];

    public function consultant()
    {
        return $this->belongsTo('App\Model\Consultant');
    }

    public function opportunity()
    {
        return $this->belongsTo('App\Model\Opportunity');
    }
}
