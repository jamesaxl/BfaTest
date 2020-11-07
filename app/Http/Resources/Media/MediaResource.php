<?php

namespace App\Http\Resources\Media;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
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
            'title' => $this->title ,
            'publication_date' => $this->publication_date ,
            'description' => $this->description ,
            'type' => $this->type ,
            'country' => $this->country !== null ? $this->country->name : null,
            'sector' => $this->sector !== null ? $this->sector->name : null,
            'sub_sector' => $this->sub_sector !== null ? $this->sub_sector->name : null,
            'project' => $this->project !== null ? $this->project->name : null,
            'key_words' => $this->key_words ,
            'file' => $this->file ,
        ];
    }
}
