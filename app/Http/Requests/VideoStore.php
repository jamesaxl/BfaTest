<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class VideoStore extends FormRequest
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
        if ( array_key_exists('content', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['content'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));

        if ( array_key_exists('video_url', $errors) )
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['video_url'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
     }
}
