<?php

namespace App\Http\Requests\Funder;

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
            'name' => 'min:3|string|max:255',
            'organization_type_id' => 'integer|exists:account_types,id',
            'organization_sub_type_id' => 'integer|exists:account_sub_types,id',
            'email' => 'string|email|max:255|unique:organizations,email,'.$this->id,
            'sectors' => 'json',
            'language_id' => 'exists:languages,id',
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
        if (array_key_exists('name', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['name'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('email', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['email'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('company_type_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['funder_type_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('sectors', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['sectors'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('language_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['language_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
