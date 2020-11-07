<?php

namespace App\Http\Resources\QuestionAnswer;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionAnswerResource extends JsonResource
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
            'paragraph' => $this->paragraph ,
            'question' => $this->question ,
            'answer' => $this->answer ,
            'resource' => $this->resource->resource ,
            'institution' => $this->institution ,
            'answer_date' => $this->answer_date ,
            'country' => $this->country !== null ? $this->country->name : null,
            'sector' => $this->sector !== null ? $this->sector->name : null,
            'sub_sector' => $this->sub_sector !== null ? $this->sub_sector->name : null,
            'theme' => $this->theme ,
            'document_type' => $this->document_type !== null ? $this->document_type->name : null,
            'document' => $this->document ,
            'producer' => $this->producer, // user data
            'destination' => $this->destination, // user data
            'status' => $this->status ,
        ];
    }
}


