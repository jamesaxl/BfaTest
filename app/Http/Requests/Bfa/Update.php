<?php

namespace App\Http\Requests\Bfa;

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
            'role_id' => 'exists:roles,id',
            'gender' => 'in:male,female',
            'photo_path' => 'file|mimes:jpeg,png',
            'cv' => 'file|mimes:pdf',
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
        if ( array_key_exists('first_name', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['first_name'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('last_name', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['last_name'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('email', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['email'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('password', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['password'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('role_id', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['role_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('gender', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['gender'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('photo_path', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['photo_path'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if (array_key_exists('language_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['language_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
