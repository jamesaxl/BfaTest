<?php

namespace App\Http\Requests\Investor;

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
            'name' => 'min:3|max:255',
            'organization_type_id' => 'integer|exists:account_types,id',
            'organization_sub_type_id' => 'integer|exists:account_sub_types,id',
            'email' => 'string|email|max:255|unique:organizations,email,'.$this->id,
            'country_id' => 'exists:countries,id',
            'nationality_id' => 'exists:countries,id',
            'language_id' => 'exists:languages,id',
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

        if (array_key_exists('investor_type_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['investor_type_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if (array_key_exists('country_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['country_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if (array_key_exists('nationality_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['nationality_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('language_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['language_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
