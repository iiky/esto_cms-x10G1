@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Pengaturan Website';
@endphp

@extends('layouts.backend.main', ['title' => 'Pengaturan Website & SEO | '.config('app.name'), 'sub_title' => $sub_title])

@section('container')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-6">
                    {{ Breadcrumbs::render(Request::route()->getName()) }}
                </div>
                <div class="col-6 text-end">
                    <span class="badge badge-primary px-3 py-2"><i class="fa fa-shield me-1"></i> Konfigurasi Operasional & SEO</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                <strong><i class="fa fa-exclamation-triangle me-2"></i> Periksa kembali data form:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 border-bottom">
                        <ul class="nav nav-tabs border-tab nav-primary" id="settingTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="operasional-tab" data-bs-toggle="tab" href="#operasional" role="tab" aria-controls="operasional" aria-selected="true">
                                    <i class="fa fa-building-o me-2"></i> Operasional & Identitas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="seo-tab" data-bs-toggle="tab" href="#seo" role="tab" aria-controls="seo" aria-selected="false">
                                    <i class="fa fa-google me-2"></i> SEO Default Web
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="webmaster-tab" data-bs-toggle="tab" href="#webmaster" role="tab" aria-controls="webmaster" aria-selected="false">
                                    <i class="fa fa-line-chart me-2"></i> Webmaster & Analytics
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="social-tab" data-bs-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">
                                    <i class="fa fa-share-alt me-2"></i> Media Sosial
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="scripts-tab" data-bs-toggle="tab" href="#scripts" role="tab" aria-controls="scripts" aria-selected="false">
                                    <i class="fa fa-code me-2"></i> Skrip Kustom
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form class="form theme-form" method="post" action="{{ $action }}" enctype="multipart/form-data" id="settingForm">
                        @csrf
                        <div class="card-body">
                            <div class="tab-content" id="settingTabContent">

                                <!-- TAB 1: OPERASIONAL & IDENTITAS -->
                                <div class="tab-pane fade show active" id="operasional" role="tabpanel" aria-labelledby="operasional-tab">
                                    <div class="card-header px-0 pt-0 pb-3 mb-4 border-bottom">
                                        <h5 class="text-primary"><i class="fa fa-id-card-o me-2"></i> Identitas Website & Informasi Operasional Kantor</h5>
                                        <p class="text-muted mb-0 small">Kelola informasi profil entitas bisnis, kontak operasional, serta aset visual logo utama.</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="title">Nama Situs / Website Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $settings['title'] ?? '') }}" placeholder="Contoh: ESTO CMS" required>
                                            <small class="text-muted">Nama brand situs yang tampil di header dan title browser.</small>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="tagline">Tagline / Slogan Situs</label>
                                            <input type="text" name="tagline" id="tagline" class="form-control @error('tagline') is-invalid @enderror" value="{{ old('tagline', $settings['tagline'] ?? '') }}" placeholder="Contoh: Portal Informasi & Solusi Media Terpercaya">
                                            <small class="text-muted">Slogan ringkas yang merepresentasikan visi situs web Anda.</small>
                                            @error('tagline')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="company_name">Nama Perusahaan / Organisasi</label>
                                            <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name', $settings['company_name'] ?? '') }}" placeholder="Contoh: PT. ESTO Solusi Media">
                                            <small class="text-muted">Nama resmi perusahaan untuk keperluan legalitas & copyright.</small>
                                            @error('company_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="email">Email Resmi / Operasional</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $settings['email'] ?? '') }}" placeholder="info@perusahaan.com">
                                            </div>
                                            <small class="text-muted">Email untuk korespondensi publik dan notifikasi sistem.</small>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="phone">Telepon / WhatsApp Customer Service</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-whatsapp"></i></span>
                                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $settings['phone'] ?? '') }}" placeholder="+62 812-3456-7890">
                                            </div>
                                            <small class="text-muted">Nomor kontak telepon atau WhatsApp operasional.</small>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="operating_hours">Jam Operasional Kantor</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                                <input type="text" name="operating_hours" id="operating_hours" class="form-control @error('operating_hours') is-invalid @enderror" value="{{ old('operating_hours', $settings['operating_hours'] ?? '') }}" placeholder="Senin - Jumat: 08:00 - 17:00 WIB">
                                            </div>
                                            <small class="text-muted">Jadwal layanan operasional kantor atau customer care.</small>
                                            @error('operating_hours')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-4">
                                            <label class="form-label fw-bold" for="address">Alamat Lengkap Kantor</label>
                                            <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror" placeholder="Contoh: Gedung Perkantoran Lt. 5, Jl. Jenderal Sudirman No. 10, Jakarta Pusat 10220">{{ old('address', $settings['address'] ?? '') }}</textarea>
                                            <small class="text-muted">Alamat fisik kantor yang akan tampil pada footer dan schema metadata.</small>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="logo">Logo Website Utama</label>
                                            <input type="file" name="logo" id="logo" class="form-control @error('logo') is-invalid @enderror" accept="image/*" onchange="previewFile(this, '#preview-logo')">
                                            <small class="text-muted d-block mt-1">Format: PNG, SVG, JPG, WebP. Maks 2MB. Disarankan background transparan.</small>
                                            <div class="p-2 border rounded bg-light mt-2 text-center" style="max-width: 250px;">
                                                <img id="preview-logo" src="{{ $settings['logo'] ?? asset('/assets/images/logo/logo.png') }}" alt="Logo Website" style="max-height: 50px; max-width: 100%; object-fit: contain;">
                                            </div>
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="favicon">Favicon Browser</label>
                                            <input type="file" name="favicon" id="favicon" class="form-control @error('favicon') is-invalid @enderror" accept="image/*" onchange="previewFile(this, '#preview-favicon')">
                                            <small class="text-muted d-block mt-1">Format: ICO, PNG, SVG. Maks 2MB. Disarankan rasio 1:1 (32x32 atau 64x64 px).</small>
                                            <div class="p-2 border rounded bg-light mt-2 text-center" style="max-width: 80px;">
                                                <img id="preview-favicon" src="{{ $settings['favicon'] ?? asset('/assets/images/favicon.png') }}" alt="Favicon" style="height: 36px; width: 36px; object-fit: contain;">
                                            </div>
                                            @error('favicon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 2: SEO DEFAULT WEB -->
                                <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                                    <div class="card-header px-0 pt-0 pb-3 mb-4 border-bottom">
                                        <h5 class="text-primary"><i class="fa fa-search me-2"></i> Pengaturan Global SEO (Search Engine Optimization)</h5>
                                        <p class="text-muted mb-0 small">Konfigurasi fallback metadata standar yang digunakan oleh mesin pencari (Google, Bing) dan platform media sosial ketika halaman web tidak memiliki metadata spesifik.</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" for="meta_title">Default Meta Title</label>
                                                <input type="text" name="meta_title" id="meta_title" class="form-control @error('meta_title') is-invalid @enderror" value="{{ old('meta_title', $settings['meta_title'] ?? '') }}" placeholder="Contoh: ESTO CMS - Solusi Web Portal Modern & Cepat">
                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                    <small class="text-muted">Judul utama halaman web di hasil pencarian Google (Rekomendasi: 50 - 60 karakter).</small>
                                                    <small><span id="meta-title-count">0</span> / 60 karakter</small>
                                                </div>
                                                @error('meta_title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold" for="description">Default Meta Description</label>
                                                <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi ringkas dan menarik tentang situs web Anda yang akan muncul di bawah judul pencarian Google...">{{ old('description', $settings['description'] ?? '') }}</textarea>
                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                    <small class="text-muted">Rangkuman konten untuk hasil SERP (Rekomendasi: 120 - 160 karakter).</small>
                                                    <small><span id="desc-count">0</span> / 160 karakter</small>
                                                </div>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold" for="keyword">Default Meta Keywords</label>
                                                <input type="text" name="keyword" id="keyword" class="form-control tags @error('keyword') is-invalid @enderror" value="{{ old('keyword', $settings['keyword'] ?? '') }}" placeholder="cms, portal berita, media, teknologi">
                                                <small class="text-muted">Pisahkan kata kunci dengan tanda koma (,).</small>
                                                @error('keyword')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold" for="author">Default Penulis / Author</label>
                                                    <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $settings['author'] ?? '') }}" placeholder="ESTO CMS Editorial Team">
                                                    <small class="text-muted">Nama penulis default untuk tag meta author.</small>
                                                    @error('author')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label fw-bold" for="robots_index">Robots Index Directive</label>
                                                    <select name="robots_index" id="robots_index" class="form-select @error('robots_index') is-invalid @enderror">
                                                        <option value="index, follow" {{ old('robots_index', $settings['robots_index'] ?? '') == 'index, follow' ? 'selected' : '' }}>index, follow (Situs Publik - Direkomendasikan)</option>
                                                        <option value="noindex, nofollow" {{ old('robots_index', $settings['robots_index'] ?? '') == 'noindex, nofollow' ? 'selected' : '' }}>noindex, nofollow (Situs Privat / Maintenance / Staging)</option>
                                                        <option value="index, nofollow" {{ old('robots_index', $settings['robots_index'] ?? '') == 'index, nofollow' ? 'selected' : '' }}>index, nofollow (Indeks Halaman, Jangan Ikuti Link Luar)</option>
                                                        <option value="noindex, follow" {{ old('robots_index', $settings['robots_index'] ?? '') == 'noindex, follow' ? 'selected' : '' }}>noindex, follow (Jangan Indeks, Tetap Ikuti Link)</option>
                                                    </select>
                                                    <small class="text-muted">Petunjuk bagi web crawler Googlebot & Bingbot.</small>
                                                    @error('robots_index')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold" for="og_image">Default Social Share Banner (Open Graph / Twitter Card)</label>
                                                <input type="file" name="og_image" id="og_image" class="form-control @error('og_image') is-invalid @enderror" accept="image/*" onchange="previewFile(this, '#preview-og')">
                                                <small class="text-muted d-block mt-1">Gambar banner yang muncul saat link website dibagikan ke WhatsApp, Facebook, Twitter, LinkedIn. Format: JPG/PNG/WebP, Maks 3MB (Rasio 1.91:1, disarankan 1200 x 630 px).</small>
                                                <div class="p-2 border rounded bg-light mt-2" style="max-width: 320px;">
                                                    <img id="preview-og" src="{{ $settings['og_image'] ?? asset('/assets/images/logo/logo.png') }}" alt="Social Share Banner" class="img-fluid rounded" style="max-height: 140px; width: 100%; object-fit: cover;">
                                                </div>
                                                @error('og_image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- SERP Preview Card -->
                                        <div class="col-md-4">
                                            <div class="card border shadow-sm">
                                                <div class="card-header bg-light py-2 px-3">
                                                    <h6 class="mb-0 text-dark"><i class="fa fa-eye me-1 text-primary"></i> Google SERP Snippet Preview</h6>
                                                </div>
                                                <div class="card-body p-3">
                                                    <div class="p-3 bg-white rounded border">
                                                        <div class="d-flex align-items-center mb-1">
                                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-2" style="width: 26px; height: 26px;">
                                                                <img src="{{ $settings['favicon'] ?? asset('/assets/images/favicon.png') }}" alt="icon" style="width: 16px; height: 16px;">
                                                            </div>
                                                            <div>
                                                                <div class="small text-truncate" style="font-size: 12px; color: #202124;" id="serp-site-name">{{ $settings['title'] ?? 'ESTO CMS' }}</div>
                                                                <div class="text-muted small" style="font-size: 11px;">{{ url('/') }}</div>
                                                            </div>
                                                        </div>
                                                        <h6 class="mb-1" style="color: #1a0dab; font-size: 16px; font-weight: 500; cursor: pointer; line-height: 1.3;" id="serp-title">
                                                            {{ $settings['meta_title'] ?? $settings['title'] ?? 'ESTO CMS - Portal Solusi Media' }}
                                                        </h6>
                                                        <p class="text-muted mb-0 small" style="font-size: 12px; line-height: 1.4;" id="serp-desc">
                                                            {{ $settings['description'] ?? 'Deskripsi singkat website Anda akan tampil di bagian ringkasan hasil pencarian mesin telusur Google.' }}
                                                        </p>
                                                    </div>
                                                    <small class="text-muted mt-2 d-block fst-italic">Pratinjau visual ini merefleksikan estimasi tampilan cuplikan pencarian organik di Google.</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 3: WEBMASTER & ANALYTICS -->
                                <div class="tab-pane fade" id="webmaster" role="tabpanel" aria-labelledby="webmaster-tab">
                                    <div class="card-header px-0 pt-0 pb-3 mb-4 border-bottom">
                                        <h5 class="text-primary"><i class="fa fa-line-chart me-2"></i> Integrasi Google Analytics & Google Search Console</h5>
                                        <p class="text-muted mb-0 small">Hubungkan website dengan perangkat analitik resmi Google untuk memantau trafik pengunjung, performa kata kunci, dan indeksasi halaman.</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="card border p-3 h-100">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa fa-area-chart text-warning fs-4 me-2"></i>
                                                    <h6 class="mb-0 fw-bold">Google Analytics 4 (GA4)</h6>
                                                </div>
                                                <p class="text-muted small mb-3">Masukkan ID Pengukuran (Measurement ID) Google Analytics Anda. Script tracking gtag.js akan diinjeksi secara otomatis pada seluruh halaman situs.</p>
                                                
                                                <label class="form-label fw-bold" for="google_analytics_id">Measurement ID (GA4)</label>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                                    <input type="text" name="google_analytics_id" id="google_analytics_id" class="form-control @error('google_analytics_id') is-invalid @enderror" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="G-XXXXXXXXXX atau UA-XXXXXXXX-X">
                                                </div>
                                                <small class="text-muted">Contoh: <code>G-4ABC123XYZ</code></small>
                                                @error('google_analytics_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-4">
                                            <div class="card border p-3 h-100">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fa fa-google text-primary fs-4 me-2"></i>
                                                    <h6 class="mb-0 fw-bold">Google Search Console Verification</h6>
                                                </div>
                                                <p class="text-muted small mb-3">Verifikasi kepemilikan domain di Google Search Console dengan memasukkan kode HTML Tag verifikasi tanpa perlu mengunggah file HTML manual ke server.</p>
                                                
                                                <label class="form-label fw-bold" for="google_search_console">Verification Meta Code</label>
                                                <div class="input-group mb-2">
                                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                                    <input type="text" name="google_search_console" id="google_search_console" class="form-control @error('google_search_console') is-invalid @enderror" value="{{ old('google_search_console', $settings['google_search_console'] ?? '') }}" placeholder="Contoh: a1b2c3d4e5f6g7h8i9j0k">
                                                </div>
                                                <small class="text-muted">Masukkan kode unik dari tag <code>&lt;meta name="google-site-verification" content="..."&gt;</code>.</small>
                                                @error('google_search_console')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 4: MEDIA SOSIAL -->
                                <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                                    <div class="card-header px-0 pt-0 pb-3 mb-4 border-bottom">
                                        <h5 class="text-primary"><i class="fa fa-share-alt me-2"></i> Akun Media Sosial Resmi Perusahaan</h5>
                                        <p class="text-muted mb-0 small">Tautan media sosial ini akan digunakan pada komponen footer website, kartu kontak, dan schema markup organisasi.</p>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="facebook_url"><i class="fa fa-facebook-square text-primary me-1"></i> Facebook Page URL</label>
                                            <input type="url" name="facebook_url" id="facebook_url" class="form-control @error('facebook_url') is-invalid @enderror" value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" placeholder="https://facebook.com/namaperusahaan">
                                            @error('facebook_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="instagram_url"><i class="fa fa-instagram text-danger me-1"></i> Instagram Profile URL</label>
                                            <input type="url" name="instagram_url" id="instagram_url" class="form-control @error('instagram_url') is-invalid @enderror" value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" placeholder="https://instagram.com/namaperusahaan">
                                            @error('instagram_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="twitter_url"><i class="fa fa-twitter text-info me-1"></i> Twitter / X Profile URL</label>
                                            <input type="url" name="twitter_url" id="twitter_url" class="form-control @error('twitter_url') is-invalid @enderror" value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" placeholder="https://twitter.com/namaperusahaan">
                                            @error('twitter_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="linkedin_url"><i class="fa fa-linkedin-square text-primary me-1"></i> LinkedIn Company URL</label>
                                            <input type="url" name="linkedin_url" id="linkedin_url" class="form-control @error('linkedin_url') is-invalid @enderror" value="{{ old('linkedin_url', $settings['linkedin_url'] ?? '') }}" placeholder="https://linkedin.com/company/namaperusahaan">
                                            @error('linkedin_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="youtube_url"><i class="fa fa-youtube-play text-danger me-1"></i> YouTube Channel URL</label>
                                            <input type="url" name="youtube_url" id="youtube_url" class="form-control @error('youtube_url') is-invalid @enderror" value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" placeholder="https://youtube.com/@namaperusahaan">
                                            @error('youtube_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 5: SKRIP KUSTOM -->
                                <div class="tab-pane fade" id="scripts" role="tabpanel" aria-labelledby="scripts-tab">
                                    <div class="card-header px-0 pt-0 pb-3 mb-4 border-bottom">
                                        <h5 class="text-primary"><i class="fa fa-code me-2"></i> Injeksi Skrip & Kode Kustom (Head / Footer)</h5>
                                        <p class="text-muted mb-0 small">Masukkan kode skrip tambahan seperti Meta Pixel (Facebook Pixel), Google Tag Manager, custom CSS, atau widget chat langsung.</p>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold" for="custom_head_scripts"><i class="fa fa-header me-1"></i> Skrip Header Kustom (Custom Head Scripts)</label>
                                        <p class="text-muted small mb-2">Kode di bawah ini akan diinjeksi tepat sebelum tag penutup <code>&lt;/head&gt;</code> pada setiap halaman frontend.</p>
                                        <textarea name="custom_head_scripts" id="custom_head_scripts" rows="6" class="form-control font-monospace @error('custom_head_scripts') is-invalid @enderror" placeholder="<!-- Masukkan skrip penjejak, custom CSS, atau Tag Manager di sini -->&#10;<script>&#10;  // Custom head scripts&#10;</script>">{{ old('custom_head_scripts', $settings['custom_head_scripts'] ?? '') }}</textarea>
                                        @error('custom_head_scripts')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold" for="custom_footer_scripts"><i class="fa fa-terminal me-1"></i> Skrip Footer Kustom (Custom Footer Scripts)</label>
                                        <p class="text-muted small mb-2">Kode di bawah ini akan diinjeksi tepat sebelum tag penutup <code>&lt;/body&gt;</code> pada setiap halaman frontend (misalnya widget live chat Crisp, Tawk.to, atau WhatsApp floating button).</p>
                                        <textarea name="custom_footer_scripts" id="custom_footer_scripts" rows="6" class="form-control font-monospace @error('custom_footer_scripts') is-invalid @enderror" placeholder="<!-- Masukkan skrip widget chat, analitik pihak ketiga di sini -->&#10;<script>&#10;  // Custom footer scripts&#10;</script>">{{ old('custom_footer_scripts', $settings['custom_footer_scripts'] ?? '') }}</textarea>
                                        @error('custom_footer_scripts')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-end bg-light border-top">
                            <button class="btn btn-primary px-4 py-2" type="submit" id="btnSubmit">
                                <i class="fa fa-save me-2"></i> Simpan Seluruh Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        // Preview File Helper
        function previewFile(input, targetSelector) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(targetSelector).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(document).ready(function() {
            // Persist Active Tab via Hash
            let hash = window.location.hash;
            if (hash) {
                let triggerEl = document.querySelector('#settingTab a[href="' + hash + '"]');
                if (triggerEl) {
                    let tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                }
            }

            $('#settingTab a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.getAttribute('href');
            });

            // Meta Title character counter & SERP sync
            function updateMetaTitle() {
                let metaVal = $('#meta_title').val();
                let titleVal = $('#title').val();
                let displayTitle = metaVal || titleVal || 'ESTO CMS';
                $('#meta-title-count').text(metaVal.length);
                $('#serp-title').text(displayTitle);
            }

            // Description character counter & SERP sync
            function updateDescription() {
                let val = $('#description').val();
                $('#desc-count').text(val.length);
                if (val.length > 0) {
                    $('#serp-desc').text(val);
                } else {
                    $('#serp-desc').text('Deskripsi singkat website Anda akan tampil di bagian ringkasan hasil pencarian mesin telusur Google.');
                }
            }

            // Site name sync
            function updateSiteName() {
                let val = $('#title').val() || 'ESTO CMS';
                $('#serp-site-name').text(val);
                updateMetaTitle();
            }

            $('#title').on('input', updateSiteName);
            $('#meta_title').on('input', updateMetaTitle);
            $('#description').on('input', updateDescription);

            // Initial counter triggers
            updateSiteName();
            updateMetaTitle();
            updateDescription();
        });
    </script>
@endsection
