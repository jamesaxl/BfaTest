<?php

namespace App\Http\Resources\KpiIndicator;

use Illuminate\Http\Resources\Json\JsonResource;

class KpiIndicatorResource extends JsonResource
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
            'id' => $this->id,
        ];
    }
}

