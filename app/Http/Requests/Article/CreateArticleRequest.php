<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'body' => 'required|array',
            'body.short' => 'required|string',
            'body.long' => 'required|string',
            'status' => 'nullable|boolean',
            'special_words' => 'required|array',
            'category_ids' => 'required|exists:categories,id',
            'slug' => 'nullable|string|max:255|unique:articles,slug'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'body' => 'متن',
            'body.short' => 'توضیج کوتاه',
            'body.long' => 'متن خبر',
            'special_words' => 'کلمات کلیذی',
            'category_ids' => 'دسته بندی',
            'slug' => 'اسلاگ'
        ];
    }
}
