<?php

namespace App\Http\Resources\Funder;

use Illuminate\Http\Resources\Json\JsonResource;

class FunderResource extends JsonResource
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
            'photo_path' => $this->photo_path,
            'name' => $this->name,
            'funder_type' => $this->FunderType,
        ];
    }
}

