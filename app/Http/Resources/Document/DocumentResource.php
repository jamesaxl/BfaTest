<?php

namespace App\Http\Resources\Document;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'title'  => $this->title ,
            'reference'  => $this->reference ,
            'institution'  => $this->institution ,
            'document_path'  => $this->document_path ,
            'document_type'  => $this->document_type !== null ? $this->document_type->name : null,
            'document_sub_type'  => $this->document_sub_type !== null ? $this->document_sub_type->name : null,
            'country'  => $this->country !== null ? $this->country->name : null,
            'sector'  => $this->sector !== null ? $this->sector->name : null,
            'sub_sector'  => $this->sub_sector !== null ? $this->sub_sector->name : null,
            'key_words'  => $this->key_words ,
            'file'  => $this->file ,
            'file_transcript'  => $this->file_transcript ,
        ];
    }
}
