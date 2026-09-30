<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'title'               => 'required|string|max:255',
            'slug'                => 'nullable|string|max:255|unique:articles,slug',
            'image'               => 'required|image|file|max:2048',
            'content'             => 'required',
            'article_category_id' => 'required|exists:article_categories,id',
            'published_at'        => 'required',
            'tags'                => 'nullable|string|max:255',
            'meta_title'          => 'nullable|string|max:255',
            'meta_description'    => 'nullable|string|max:500',
            'meta_keywords'       => 'nullable|string|max:255',
            'canonical_url'       => 'nullable|url|max:255',
        ];
    }
}
