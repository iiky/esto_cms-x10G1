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
            // Operasional & Identitas Web
            'title'                 => ['required', 'string', 'max:100'],
            'tagline'               => ['nullable', 'string', 'max:255'],
            'company_name'          => ['nullable', 'string', 'max:150'],
            'email'                 => ['nullable', 'email', 'max:100'],
            'phone'                 => ['nullable', 'string', 'max:50'],
            'address'               => ['nullable', 'string', 'max:500'],
            'operating_hours'       => ['nullable', 'string', 'max:150'],
            'logo'                  => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:2048'],
            'favicon'               => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,ico', 'max:2048'],

            // SEO Default Web
            'meta_title'            => ['nullable', 'string', 'max:150'],
            'description'           => ['nullable', 'string', 'max:500'],
            'keyword'               => ['nullable', 'string', 'max:500'],
            'author'                => ['nullable', 'string', 'max:100'],
            'og_image'              => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg,webp', 'max:3072'],
            'robots_index'          => ['nullable', 'string', 'in:index, follow,noindex, nofollow,index, nofollow,noindex, follow'],

            // Integrasi Webmaster & Analytics
            'google_analytics_id'   => ['nullable', 'string', 'max:50'],
            'google_search_console' => ['nullable', 'string', 'max:255'],

            // Media Sosial
            'facebook_url'          => ['nullable', 'url', 'max:255'],
            'instagram_url'         => ['nullable', 'url', 'max:255'],
            'twitter_url'           => ['nullable', 'url', 'max:255'],
            'linkedin_url'          => ['nullable', 'url', 'max:255'],
            'youtube_url'           => ['nullable', 'url', 'max:255'],

            // Skrip Kustom
            'custom_head_scripts'   => ['nullable', 'string'],
            'custom_footer_scripts' => ['nullable', 'string'],
        ];
    }
}
