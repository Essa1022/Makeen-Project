<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'username' => 'required|min:5|max:20|unique:users,username,' . Auth::id(),
            'phone_number' => 'required|digits:11|unique:users,phone_number,' . Auth::id(),
            'password' => ['required' , 'min:8' , 'regex:/[a-z]/' , 'regex:/[A-Z]/' , 'regex:/[0-9]/' , 'regex:/^[A-Za-z0-9\W]+$/']
        ];
    }

    public function attributes(): array
    {
        return [
            'username' => 'نام کاربری',
            'phone_number' => 'شماره موبایل',
            'password' => 'رمز عبور'
        ];
    }
}
