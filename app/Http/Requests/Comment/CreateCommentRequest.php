<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
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
            'name' => 'required|string',
            'message' => 'required|string',
            'comment_id' => 'nullable|exists:comments,id',
            'status' => 'nullable|boolean'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'نام',
            'message' => 'متن پیام'
        ];
    }
}
