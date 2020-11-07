<?php

namespace App\Http\Resources\FinancialInstitution;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'  => $this->id,
            'photo_path' => $this->photo_path ,
            'name' => $this->name,
            'financial_institution_type' => $this->FinancialInstitutionType,
        ];
    }
}

