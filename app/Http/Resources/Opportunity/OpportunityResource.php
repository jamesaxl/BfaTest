<?php

namespace App\Http\Resources\Opportunity;

use Illuminate\Http\Resources\Json\JsonResource;

class OpportunityResource extends JsonResource
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
            'continent' => $this->continent !== null ? $this->continent->name : null,
            'country' => $this->country !== null ? $this->country->name : null,
            'city' => $this->city !== null ? $this->city->name : null,
            'project' => $this->project !== null ? $this->project->name : null,
            'sector' => $this->sector !== null ? $this->sector->name : null,
            'producer' => $this->producer !== null ? $this->producer->name : null,
            'title_acquisition' => $this->title_acquisition ,
            'geo_location' => $this->geo_location ,
            'ref' => $this->ref ,
            'executing_agency' => $this->executing_agency ,
            'executing_agency_email' => $this->executing_agency_email ,
            'executing_agency_phone' => $this->executing_agency_phone ,
             'executing_agency_address' => $this->executing_agency_address ,
            'link_acquisition' => $this->link_acquisition ,
            'category_acquisition' => $this->category_acquisition ,
            'document_type' => $this->document_type ,
            'type_acquisition' => $this->type_acquisition ,
            'description_acquisition' => $this->description_acquisition ,
            'information_acquisition' => $this->information_acquisition ,
            'progress' => $this->progress ,
            'selection_mode' => $this->selection_mode ,
            'ftq' => $this->ftq ,
            'publication_date' => $this->publication_date ,
            'estimated_date_event_delivery' => $this->estimated_date_event_delivery ,
            'estimated_date_event_discount' => $this->estimated_date_event_discount ,
            'lot_number' => $this->lot_number ,
            'estimated_amount_currency' => $this->estimated_amount_currency ,
            'euro_exchange_rate' => $this->euro_exchange_rate ,
            'estimated_amount_euro' => $this->estimated_amount_euro ,
            'date_sign_contract' => $this->date_signe_contract ,
            'start_date' => $this->start_date ,
            'submission_date' => $this->submission_date ,
            'country_decision_maker_name' => $this->country_decision_maker_name ,
            'task_manager_name' => $this->task_manager_name ,
            'status' => $this->status ,
            'document_path' => $this->document_path ,
            'document_extension' => $this->document_extension ,
        ];
    }
}
