<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $table = 'questions_answers';

    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }

    public function documentType()
    {
        return $this->belongsTo('App\Model\DocumentType');
    }

    public function producer()
    {
        return $this->belongsTo('App\User', 'producer_id');
    }

    public function destination()
    {
        return $this->belongsTo('App\User', 'destination_id');
    }

}
