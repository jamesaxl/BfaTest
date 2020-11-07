<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $currencySymbol = "";
        switch ($this->currency){
            case "dollar":
                $currencySymbol = "$";
                break;
            case "euro":
                $currencySymbol = "€";
                break;
            case "uc":
                $currencySymbol = "UC";
                break;
        }
        return [
            'id' => $this->id,
            'continent' => $this->continent !== null ? $this->continent->name : null,
            'country' => $this->country !== null ? $this->country->name : null,
            'city' => $this->city !== null ? $this->city->name : null,
            'region' => $this->region,
            'sector' => $this->sector !== null ? $this->sector->name : null,
            'sub_sector' => $this->sub_sector !== null ? $this->sub_sector->name : null,
            'donor' => $this->donor ,
            'name' => $this->name ,
            'analytic_summary' => $this->analytic_summary ,
            'acquisition_summary_modalities' => $this->acquisition_summary_modalities ,
            'risks_related_to_acquisitions' => $this->risks_related_to_acquisitions ,
            'sector_market_analysis' => $this->sector_market_analysis ,
            'progress' => $this->progress ,
            'executing_agency' => $this->executing_agency ,
            'boss_name' => $this->boss_name ,
            'executing_agency_email' => $this->executing_agency_email ,
            'executing_agency_phone' => $this->executing_agency_phone ,
            'website' => $this->website ,
            'decision_maker_name_in_country' => $this->decision_maker_name_in_country ,
            'email_decision_maker' => $this->email_decision_maker ,
            'phone_decision_maker' => $this->phone_decision_maker ,
            'division_in_charge_of_the_project_at_the_donor' => $this->division_in_charge_of_the_project_at_the_donor ,
            'project_status' => $this->project_status ,
            'approval_date' => $this->approval_date ,
            'effective_first_disbursement' => $this->effective_first_disbursement ,
            'actual_first_disbursement' => $this->actual_first_disbursement ,
            'latest_disbursement' => $this->latest_disbursement ,
            'planned_project_completion_date' => $this->planned_project_completion_date ,
            'original_closing_date' => $this->original_closing_date ,
            'planned_final_disbursement_date' => $this->planned_final_disbursement_date ,
            'amount_not_disbursed' => $this->amount_not_disbursed ,
            'task_manager_name' => $this->task_manager_name ,
            'task_manager_email' => $this->task_manager_email ,
            'window_funds' => $this->window_funds ,
            'disbursement_ratio' => $this->disbursement_ratio ,
            'amount' => $this->amount,
            'amount_with_currency' => $this->amount." ".$currencySymbol,
            'currency' => $this->currency ,
            'loan_number' => $this->loan_number ,
            'entry_into_force' => $this->entry_into_force ,
            'total_undisb' => $this->total_undisb ,
            'total_undisb_with_currency' => $this->total_undisb." ".$currencySymbol ,
            'rd_regional_dept' => $this->rd_regional_dept ,
            'loans_exchange_rate_date' => $this->loans_exchange_rate_date ,
            'sector_dept' => $this->sector_dept ,
            'project_age_in_years' => $this->project_age_in_years ,
            'par_report' => $this->par_report ,
            'annex' => $this->annex ,
            'ppm' => $this->ppm ,
            'file' => $this->file ,
            'exchange_rate'=> $this->exchange_rate,
            'valid' => $this->valid ,
            'project_geo' => $this->project_geo ,
        ];
    }
}
