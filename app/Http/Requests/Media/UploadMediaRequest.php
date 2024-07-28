<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaRequest extends FormRequest
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
            'main_image' => 'nullable|file|max:10000|mimes:jpg,jpeg,png,gif,mp4',
            'second_image' => 'nullable|file|max:10000|mimes:jpg,jpeg,png,gif,mp4',
            'file' => 'nullable|file|max:10000|mimes:jpg,jpeg,png,gif,mp4'
        ];
    }
}
