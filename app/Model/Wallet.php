<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $guarded = [];

    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
    
    public function walletLog()
    {
        return $this->hasMany('App\Model\WalletLog');
    }
}
