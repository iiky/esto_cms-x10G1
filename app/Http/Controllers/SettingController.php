<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Rules\CheckingLengthDescription;

class SettingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('Setting Access'), 403);
        $this->data['action'] = route('setting.store');

        $settings = settings();
        $this->data['settings'] = $settings;

        // Variabel penunjang kompatibilitas
        $this->data['title']       = $settings['title'] ?? 'ESTO CMS';
        $this->data['tagline']     = $settings['tagline'] ?? '';
        $keyword                   = $settings['keyword'] ?? '';
        if (is_array($keyword)) {
            $keyword = implode(', ', $keyword);
        }
        $this->data['keyword']     = $keyword;
        $this->data['description'] = $settings['description'] ?? '';
        $this->data['author']      = $settings['author'] ?? '';
        $this->data['favicon']     = $settings['favicon'] ?? asset('/assets/images/favicon.png');
        $this->data['logo']        = $settings['logo'] ?? asset('/assets/images/logo/logo.png');
        $this->data['og_image']    = $settings['og_image'] ?? '';

        return view('setting.form', $this->data);
    }

    public function store(StoreSettingRequest $request)
    {
        abort_if(Gate::denies('Setting Access'), 403);

        $payload = $request->validated();

        if (isset($payload['keyword']) && is_string($payload['keyword'])) {
            $payload['keyword'] = array_filter(array_map('trim', explode(',', $payload['keyword'])));
        }

        Setting::setValue($payload);

        return redirect()->route('setting.index')->with('success', 'Pengaturan Website & SEO Default berhasil disimpan!');
    }

}
