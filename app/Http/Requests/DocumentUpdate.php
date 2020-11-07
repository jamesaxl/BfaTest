<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DocumentUpdate extends FormRequest
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
            'title' => 'string|min:3',
            'reference' => 'string|min:3',
            'institution' => 'string|min:3',
            'document_path' => 'file',
            'document_type_id' => 'exists:document_types,id',
            'document_sub_type_id' => 'exists:document_sub_types,id',
            'country_id' => 'exists:countries,id',
            'sector_id' => 'exists:sectors,id',
            'sub_sector_id' => 'exists:sub_sectors,id',
            'key_words' => 'string',
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
        if (array_key_exists('title', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['title'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('reference', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['reference'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('institution', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['institution'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('document_path', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['document_path'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('document_type_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['document_type_id'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
        if (array_key_exists('document_sub_type_id', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['document_sub_type_id'][0]
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
        if (array_key_exists('key_words', $errors))
            throw new HttpResponseException(response()->json(['error' => 1, 'message' => $errors['key_words'][0]
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
