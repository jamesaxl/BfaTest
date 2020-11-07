<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $guarded = [];
    
    public function documentSubTypes()
    {
        return $this->hasMany('App\Model\DocumentSubType');
    }
}
