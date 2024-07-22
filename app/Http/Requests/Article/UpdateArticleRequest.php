<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'body' => 'required',
            'status' => 'nullable|boolean',
            'special_words' => 'required|array',
            'category_id' => 'required|exists:categories,id'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'body' => 'متن',
            'special_words' => 'کلمات ویژه',
            'category_id' => 'دسته بندی',
            'slug' => 'اسلاگ'
        ];
    }
}
