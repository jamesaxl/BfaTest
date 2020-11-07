<?php

namespace App\Http\Resources\FirmConsultant;

use Illuminate\Http\Resources\Json\JsonResource;

class FirmConsultantResource extends JsonResource
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
            'name' => $this-> name,
            'consultant_type' => $this->consultantType,
        ];
    }
}

