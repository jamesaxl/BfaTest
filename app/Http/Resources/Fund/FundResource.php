<?php

namespace App\Http\Resources\Fund;

use Illuminate\Http\Resources\Json\JsonResource;

class FundResource extends JsonResource
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
            'fund_name' => $this->fund_name ,
            'intervention_sectors' => $this->intervention_sectors ,
            'available_amount' => $this->available_amount ,
            'source' => $this->source ,
            'type' => $this->type ,
            'sub_type' => $this->sub_type ,
            'fund_manager' => $this->fund_manager ,
            'fund_nature' => $this->fund_nature ,
            'sustainability' => $this->sustainability ,
            'adaptation_mitigation_bias' => $this->adaptation_mitigation_bias ,
            'recipients_type' => $this->recipients_type ,
            'decision_making_information' => $this->decision_making_information ,
            'financial_instrument' => $this->financial_instrument ,
            'monitoring_reporting_procedures' => $this->monitoring_reporting_procedures ,
            'eligibility_criteria' => $this->eligibility_criteria ,
            'application_timeframe' => $this->application_timeframe ,
            'key_inputs_required_throughout_the_process' => $this->key_inputs_required_throughout_the_process ,
            'further_application_support_sources' => $this->further_application_support_sources ,
            'recent_funded_projects_examples' => $this->recent_funded_projects_examples ,
            'website' => $this->website ,
            'contact_name' => $this->contact_name ,
            'contact_email' => $this->contact_email ,
            'contact_phone' => $this->contact_phone ,
            'file' => $this->file ,
        ];
    }
}
