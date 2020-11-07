<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class QuestionAnswerUpdate extends FormRequest
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
            'status' => 'in:public,private',
            'document_type_id' => 'exists:document_types,id',
            'producer_id' => 'exists:users,id',
            'destination_id' => 'exists:users,id',
            'country_id' => 'exists:countries,id',
            'sector_id' => 'exists:sectors,id',
            'sub_sector_id' => 'exists:sub_sectors,id',
            'document' => 'file',
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
        if (array_key_exists('status', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['status'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('producer_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['producer_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('document_type_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['document_type_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('destination_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['destination_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('country_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['country_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('sector_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['sector_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('sub_sector_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['sub_sector_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('document', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['document'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
