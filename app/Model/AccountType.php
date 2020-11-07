<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $guarded = [];
    
    public function accountSubTypes()
    {
        return $this->belongsTo('App\Model\AccountSubType');
    }
}
