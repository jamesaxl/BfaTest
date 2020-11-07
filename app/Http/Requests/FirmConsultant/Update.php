<?php

namespace App\Http\Requests\FirmConsultant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Update extends FormRequest
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
            'name' => 'min:3|max:255|string',
            'email' => 'string|email|max:255|unique:organizations,email,'.$this->id,
            'organization_type_id' => 'required|integer|exists:account_types,id',
            'organization_sub_type_id' => 'required|integer|exists:account_sub_types,id',
            'country_id' => 'exists:countries,id',
            'nationality_id' => 'exists:countries,id',
            'city_id' => 'exists:cities,id',
            'language_id' => 'exists:languages,id',
            'is_enabled' => 'boolean',
            'status' => 'in:active,blacklist',
            'evaluation' => 'in:1,2,3,4,5',
            'photo_path' => 'file|mimes:jpg,png',
            'sectors' => 'array|min:1',
            'sectors.*' => 'integer|exists:sectors',
            'sub_sectors' => 'array|min:1',
            'sub_sectors.*' => 'integer|exists:sub_sectors',
            'specialities' => 'array|min:1',
            'specialities.*' => 'integer|exists:specialities',
            'qualifications' => 'array|min:1',
            'qualifications.*' => 'integer|exists:qualifications',
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
