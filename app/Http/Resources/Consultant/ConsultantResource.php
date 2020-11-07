<?php

namespace App\Http\Resources\Consultant;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultantResource extends JsonResource
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

