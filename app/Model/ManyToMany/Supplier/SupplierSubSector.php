<?php

namespace App\Model\ManyToMany\Supplier;

use Illuminate\Database\Eloquent\Model;

class SupplierSubSector extends Model
{
    protected $fillable = [
        'supplier_id',
        'sub_sector_id',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Model\Supplier');
    }

    public function subSector()
    {
        return $this->belongsTo('App\Model\SubSector');
    }
}
