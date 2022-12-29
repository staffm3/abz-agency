<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ValidateUsersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     */
    public function rules()
    {
        return [
            "page" => "numeric|min:1",
            "offset" => "numeric|min:0",
            "count" => "numeric|min:1|max:100"
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation failed',
            'fails'      => $validator->errors()
        ], 422));
    }
}
