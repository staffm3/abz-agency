<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreMainRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => "required|string|max:60|min:2",
            "email" => "required|email|min:2|max:100",
            "phone" => "required|string|regex:^[\+]{0,1}380([0-9]{9})^",
            "position_id" => "required|numeric|min:1|exists:\App\Models\Position,id",
            "photo" => "required|file|mimes:jpeg,jpg|max:5120|dimensions:min_width=70,min_height=70"
        ];
    }
    public function messages()
    {
        return [
            "photo.mimes" => "Image is invalid.",
            "photo.max" => "The photo may not be greater than 5 Mbytes."
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation failed',
            'fails'      => $validator->errors()
        ]));
    }
}
