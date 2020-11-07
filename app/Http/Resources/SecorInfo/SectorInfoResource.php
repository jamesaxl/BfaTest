<?php

namespace App\Http\Resources\SectorInfo;

use Illuminate\Http\Resources\Json\JsonResource;

class SectorInfoResource extends JsonResource
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
            'sector_overview' =>  $this->sector_overview,
            'main_donors' =>  $this->main_donors,
            'document' =>  $this->document,
            'country' =>  $this->country,
            'sector' =>  $this->sector,
        ];
    }
}
