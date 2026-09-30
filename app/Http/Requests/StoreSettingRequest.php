<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
            'title'       => ['required', 'string', 'max:100'],
            'author'      => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'keyword'     => ['nullable', 'string'],
            'favicon'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,ico', 'max:2048'],
        ];
    }
}
