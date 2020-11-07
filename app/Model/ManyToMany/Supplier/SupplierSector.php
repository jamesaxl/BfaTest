<?php

namespace App\Model\ManyToMany\Supplier;

use Illuminate\Database\Eloquent\Model;

class SupplierSector extends Model
{
    protected $fillable = [
        'supplier_id',
        'sector_id',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Model\Supplier');
    }

    public function sector()
    {
        return $this->belongsTo('App\Model\Sector');
    }
}
