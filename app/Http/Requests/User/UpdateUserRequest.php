<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "username" => "required|unique:users,username," . $this->id,
            "phone_number" => "required|digits:11|unique:users,phone_number," . $this->id,
            "password" => ["required" , "min:8" , "regex:/[a-z]/" , "regex:/[A-Z]/" , "regex:/[0-9]/"]
        ];
    }
}
