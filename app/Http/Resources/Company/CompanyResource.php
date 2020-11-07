<?php

namespace App\Http\Resources\Company;

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
            'country'  => $this->country !== null ? $this->country->name : null ,
            'photo_path' => $this->photo_path ,
            'name' => $this-> name,
            'company_type' => $this->companyType !== null ? $this->companyType->name : null ,
            'annual_turnover' => $this->annual_turnover ,
            'evaluation' => $this->evaluation,
            'country_id' => $this->country !== null ? $this->country->name : null,
            'language' => $this->language ,
            'email' => $this->email ,
            'bp' => $this->bp ,
            'address' => $this->address ,
            'postal_code' => $this->postal_code ,
            'city_id' => $this->city !== null ? $this->city->name : null,
            'phone' => $this->phone ,
            'fax' => $this->fax ,
            'preview' => $this->preview ,
            'status' => $this->status ,
            'sectors' => $this->companySectors !== null ? $this->companySectors : null ,
            'sub_sectors' => $this->companySubSectors !== null ? $this->companySubSectors : null ,
            'specialities' => $this->companySpecialities !== null ? $this->companySpecialities : null ,
            'is_enabled' => $this->is_enabled ,
        ];
    }
}

