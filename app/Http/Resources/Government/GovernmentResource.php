<?php

namespace App\Http\Resources\Government;

use Illuminate\Http\Resources\Json\JsonResource;

class GovernmentResource extends JsonResource
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
            'government_type' => $this->governmentType,
        ];
    }
}

