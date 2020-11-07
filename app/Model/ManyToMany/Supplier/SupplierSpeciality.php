<?php

namespace App\Model\ManyToMany\Supplier;

use Illuminate\Database\Eloquent\Model;

class SupplierSpeciality extends Model
{
    protected $fillable = [
        'supplier_id',
        'speciality_id',
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Model\Supplier');
    }

    public function speciality()
    {
        return $this->belongsTo('App\Model\Speciality');
    }
}
