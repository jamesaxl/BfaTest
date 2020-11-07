<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OpportunityStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sector_id' => 'exists:sectors,id',
            'producer_id' => 'exists:producers,id',
            'project_id' => 'exists:projects,id',
            'continent_id' => 'exists:continents,id',
            'country_id' => 'exists:countries,id',
            'city_id' => 'exists:cities,id',
            'document_path' => 'file',
            'date_event' => 'date',
            'publication_date' => 'date',
            'estimated_date_event_delivery' => 'date',
            'estimated_date_event_discount' => 'date',
            'date_sign_contract' => 'date',
            'start_date' => 'date',
            'submission_date' => 'date',
            'document_type' => 'in:general procurement notice,invitation for bids,invitation for pre-qualification,request for expression of interest,contracts o-ward',
            'selection_mode' => 'in:AOI,AON,AOO,SBQC,SMC,SED',
            'ftq' => 'in:flat rate,time spent,quantity',
            'status' => 'in:selected by the client,general procurement notice,quantity,pre-qualification,launch call for tenders,submission of tenders,opening of tenders,date receipt of DAO,analysis of tenders,non-objection from donors,award contract signature,contract start order,submission date',
            'acquisition_link' => 'url',
            'acquisition_type' => 'in:current,future',
            'valid' => 'in:yes,no',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        if ($errors) {
            foreach ($errors as $key => $value ) {
                throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors[$key][0]
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
            }
        }
    }
}
