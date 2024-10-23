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
            'title' => 'sometimes|string|max:255',
            'body' => 'sometimes|array',
            'body.short' => 'sometimes|string',
            'body.long' => 'sometimes|string',
            'special_words' => 'sometimes|array',
            'category_ids' => 'sometimes|exists:categories,id'
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'عنوان',
            'body' => 'متن',
            'body.short' => 'توضیج کوتاه',
            'body.long' => 'متن خبر',
            'special_words' => 'کلمات ویژه',
            'category_id' => 'دسته بندی'
        ];
    }
}
