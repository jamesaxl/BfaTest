<?php

namespace App\Http\Resources\Ong;

use Illuminate\Http\Resources\Json\JsonResource;

class OngResource extends JsonResource
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
            'name' => $this->name,
            'ong_type' => $this->ongType ,
        ];
    }
}

