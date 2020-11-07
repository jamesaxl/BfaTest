<?php

namespace App\Model\ManyToMany;

use Illuminate\Database\Eloquent\Model;

class WalletLogs extends Model
{
    protected $fillable = [
        'wallet_id',
        'user_id',
        'action',
        'amount',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function wallet()
    {
        return $this->belongsTo('App\Model\Wallet');
    }
    
    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }
}
