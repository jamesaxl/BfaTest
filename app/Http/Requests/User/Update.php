<?php

namespace App\Http\Requests\User;

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
            'first_name' => 'min:3|max:255',
            'last_name' => 'min:3|max:255',
            'email' => 'unique:users|max:255,email',
            'password' => 'max:255|confirmed|min:6',
            'account_type_id' => 'integer|exists:account_types,id',
            'account_sub_type_id' => 'integer|exists:account_sub_types,id',
            'country_id' => 'integer|exists:countries,id',
            'city_id' => 'integer|exists:cities,id',
            'role_id' => 'integer|exists:roles,id',
            'sectors' => 'array|min:1|max:100',
            'sectors.*' => 'integer|exists:sectors,id',
            'sub_sectors' => 'array|min:1|max:100',
            'sub_sectors.*' => 'integer|exists:sub_sectors,id',
            'qualifications' => 'array|min:1|max:100',
            'qualifications.*' => 'string',
            'countries' => 'array|min:1|max:100',
            'countries.*' => 'integer|exists:countries,id',
            'gender' => 'in:male,female',
            'organization_id' => 'integer|exists:organizations,id',
            'photo_path' => 'file|mimes:jpeg,png',
            'cv' => 'file|mimes:pdf',
            'languages' => 'array|min:1|max:100',
            'languages.*' => 'integer|exists:languages,id',
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
