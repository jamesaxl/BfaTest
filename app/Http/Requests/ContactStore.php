<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactStore extends FormRequest
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
            'first_name' => 'required|min:3|max:255',
            'last_name' => 'required|min:3|max:255',
            'email' => 'required|unique:contacts|max:255,email',
            'account_type_id' => 'required|exists:account_types,id',
            'account_sub_type_id' => 'required|exists:account_sub_types,id',
            'sectors' => 'json',
            'sub_sectors' => 'json',
            'qualifications' => 'json',
            'gender' => 'required|in:male,female',
            'photo_path' => 'file|mimes:jpeg,png',
            'cv' => 'file|mimes:pdf',
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

        if ( array_key_exists('account_type_id', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['account_type_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('account_sub_type_id', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['account_sub_type_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('gender', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['gender'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('photo_path', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['photo_path'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('cv', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['cv'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('sectors', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['sectors'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('sub_sectors', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['sub_sectors'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('qualifications', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['qualifications'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
