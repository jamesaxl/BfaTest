<?php

namespace App\Http\Resources\SubSector;

use Illuminate\Http\Resources\Json\JsonResource;

class SubSectorResource extends JsonResource
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
            'name' =>  $this->name,
            'sector' =>  $this->sector !== null ? $this->sector->name : null,
        ];
    }
}
