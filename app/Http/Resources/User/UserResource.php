<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id ,
            'photo_path' => $this->photo_path ,
            'abv_gender' => $this->abv_gender ,
            'politeness_formula' => $this->politeness_formula ,
            'name' => $this->name ,
            'first_name' => $this->first_name ,
            'last_name' => $this->last_name ,
            'gender' => $this->gender ,
            'country' => $this->country !== null ? $this->country->name : null,
            'nationality' => $this->nationality !== null ? $this->nationality->name : null,
            'account_type' => $this->accountType !== null ? $this->accountType->name : null,
            'account_sub_type' => $this->accountSubType !== null ? $this->accountSubType->name : null,
            'sectors' => $this->userSectors !== null ? $this->userSectors : null,
            'sub_sectors' => $this->userSubSectors !== null ? $this->userSubSectors : null,
            'language' => $this->language ,
            'job_title' => $this->job_title ,
            'mobile_phone' => $this->mobile_phone ,
            'whatsapp' => $this->whatsapp ,
            'home_phone' => $this->home_phone ,
            'fax' => $this->fax ,
            'email' => $this->email ,
            'personal_email' => $this->personal_email ,
            'address' => $this->address ,
            'postal_code' => $this->postal_code ,
            'website' => $this->website ,
            'biography' => $this->biography ,
            'cv' => $this->cv ,
            'is_enabled' => $this->is_enabled ,
            'qualifications' => $this->userQuallifications !== null ? $this->userQuallifications : null ,
            'city' => $this->city !== null ? $this->city->name : null,
            'role' => $this->role !== null ? $this->role->type : null,
            'is_focal' => $this->is_focal ,
            'is_expert' => $this->is_expert ,
            'organization' => $this->organization ,
        ];
    }
}
