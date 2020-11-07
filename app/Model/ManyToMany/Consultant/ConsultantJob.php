<?php

namespace App\Model\ManyToMany\Consultant;

use Illuminate\Database\Eloquent\Model;

class ConsultantJob extends Model
{
    protected $fillable = [
        'consultant_id',
        'job_id',
    ];

    public function consultant()
    {
        return $this->belongsTo('App\Model\Consultant');
    }

    public function job()
    {
        return $this->belongsTo('App\Model\Job');
    }
}
