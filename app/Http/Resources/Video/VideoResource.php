<?php

namespace App\Http\Resources\Video;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
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
            'video_url' => $this->video_url,
            'title' => $this->title,
            'type' => $this->type,
            'project_initiative' => $this->project_initiative,
            'donor' => $this->donor,
            'file' => $this->file,
            'key_words' => $this->key_words,
            'valid' => $this->valid,
            'country' => $this->country !== null ? $this->country->name : null,
            'sector' => $this->sector !== null ? $this->sector->name : null,
            'sub_sector' => $this->sub_sector !== null ? $this->sub_sector->name : null,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}
