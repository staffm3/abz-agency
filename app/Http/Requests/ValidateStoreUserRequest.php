<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ValidateStoreUserRequest extends FormRequest
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
            "email" => "required|email|min:2|max:100|unique:\App\Models\User,email",
            "phone" => "required|string|regex:^[\+]{0,1}380([0-9]{9})^|unique:\App\Models\User,phone",
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
}
