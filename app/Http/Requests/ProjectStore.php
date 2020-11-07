<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProjectStore extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'project_status' => 'in:identified,approved,in progress,completed,canceled',
            'valid' => 'in:yes,no',
            'currency' => 'in:uc,euro,dollar',
            'approval_date' => 'date',
            'planned_project_completion_date' => 'date',
            'original_closing_date' => 'date',
            'planned_final_disbursement_date' => 'date',
            'loans_exchange_rate_date' => 'date',
            'continent_id' => 'exists:continents,id',
            'country_id' => 'exists:countries,id',
            'city_id' => 'exists:cities,id',
            'sector_id' => 'exists:sectors,id',
            'sub_sector_id' => 'exists:sub_sectors,id',
            'ppm' => 'file',
            'annex' => 'file',
            'file' => 'file',
            'par_report' => 'file',
            'currency_id' => 'exists:currencies,id',
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
        if ( array_key_exists('name', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['name'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('project_status', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['project_status'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('valid', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['valid'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('currency', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['currency'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('approval_date', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['approval_date'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('planned_project_completion_date', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['planned_project_completion_date'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('original_closing_date', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['original_closing_date'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('planned_final_disbursement_date', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['planned_final_disbursement_date'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('loans_exchange_rate_date', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['loans_exchange_rate_date'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('continent_id', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['continent_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('country_id', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['country_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('city_id', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['city_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('sector_id', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['sector_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('sub_sector_id', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['sub_sector_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('ppm', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['ppm'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('annex', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['annex'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('file', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['file'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if ( array_key_exists('par_report', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['par_report'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
