<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'photo_path' => $this->photo_path ,
            'abv_gender'  => $this->abv_gender ,
            'politeness_formula'  => $this->politeness_formula ,
            'name'  => $this->name ,
            'first_name'  => $this->first_name ,
            'last_name'  => $this->last_name ,
            'gender'  => $this->gender ,
            'country'  => $this->country !== null ? $this->country->name : null ,
            'nationality'  => $this->nationality !== null ? $this->nationality->name : null,
            'company'  => $this->company ,
            'account_type'  => $this->account_type !== null ? $this->account_type->name : null,
            'sub_type'  => $this->sub_type !== null ? $this->sub_type->name : null,
            'sectors'  => $this->sectors,
            'sub_sectors'  => $this->sub_sectors,
            'qualifications'  => $this->qualifications,
            'language'  => $this->language ,
            'job_title'  => $this->job_title ,
            'mobile_phone'  => $this->mobile_phone ,
            'whatsapp'  => $this->whatsapp ,
            'home_phone'  => $this->home_phone ,
            'fax'  => $this->fax ,
            'professional_email'  => $this->professional_email ,
            'personal_email'  => $this->personal_email ,
            'city'  => $this->city !== null ? $this->city->name : null,
            'address'  => $this->address ,
            'postal_code'  => $this->postal_code ,
            'website'  => $this->website ,
            'cv'  => $this->cv ,
            'biography'  => $this->biography ,
        ];
    }
}
