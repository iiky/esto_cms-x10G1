@php
    $sub_title = ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Profil Akun';
@endphp

@extends('layouts.backend.main', ['title' => 'Profil & Keamanan Akun | '.config('app.name'), 'sub_title' => $sub_title])

@section('container')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-6">
                    {{ Breadcrumbs::render(Request::route()->getName()) }}
                </div>
                <div class="col-6 text-end">
                    <span class="badge badge-primary px-3 py-2"><i class="fa fa-user-circle me-1"></i> Pengaturan Akun & Keamanan</span>
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
                <strong><i class="fa fa-exclamation-triangle me-2"></i> Terdapat kesalahan pengisian:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Profil Singkat / User Card (Kiri) -->
            <div class="col-xl-4 col-lg-5">
                <div class="card custom-card">
                    <div class="card-header pb-0 border-bottom text-center">
                        <h5 class="mb-0">Kartu Pengguna</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar-wrapper mb-3 position-relative d-inline-block">
                            <img id="avatar-preview-card" class="rounded-circle shadow-sm border border-3 border-primary" width="120" height="120" style="object-fit: cover;" src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                        </div>
                        <h5 class="mb-1 text-primary fw-bold">{{ $user->name }}</h5>
                        <p class="text-muted small mb-2">&#64;{{ $user->username }}</p>
                        <span class="badge badge-light-primary px-3 py-1 mb-3 font-primary fw-bold fs-6">
                            <i class="fa fa-shield me-1"></i> {{ $user->role_name }}
                        </span>

                        <div class="border-top pt-3 text-start small">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="fa fa-envelope-o me-2"></i> Email</span>
                                <span class="fw-bold text-truncate" style="max-width: 180px;">{{ $user->email }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="fa fa-phone me-2"></i> Telepon</span>
                                <span class="fw-bold">{{ $profile->phone_number ?? '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="fa fa-calendar-check-o me-2"></i> Terdaftar</span>
                                <span class="fw-bold">{{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted"><i class="fa fa-check-circle-o me-2 text-success"></i> Status Email</span>
                                <span class="badge bg-success">Terverifikasi</span>
                            </div>
                        </div>

                        @if(!empty($profile->bio))
                        <div class="border-top pt-3 text-start">
                            <span class="text-muted small fw-bold d-block mb-1">Bio / Tentang Saya:</span>
                            <p class="small text-muted mb-0 fst-italic">{{ $profile->bio }}</p>
                        </div>
                        @endif

                        @if($profile->social_facebook || $profile->social_instagram || $profile->social_twitter || $profile->social_linkedin)
                        <div class="border-top pt-3 mt-3">
                            <div class="d-flex justify-content-center gap-2">
                                @if($profile->social_facebook)
                                    <a href="{{ $profile->social_facebook }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle p-2" title="Facebook"><i class="fa fa-facebook"></i></a>
                                @endif
                                @if($profile->social_instagram)
                                    <a href="{{ $profile->social_instagram }}" target="_blank" class="btn btn-outline-danger btn-sm rounded-circle p-2" title="Instagram"><i class="fa fa-instagram"></i></a>
                                @endif
                                @if($profile->social_twitter)
                                    <a href="{{ $profile->social_twitter }}" target="_blank" class="btn btn-outline-info btn-sm rounded-circle p-2" title="Twitter / X"><i class="fa fa-twitter"></i></a>
                                @endif
                                @if($profile->social_linkedin)
                                    <a href="{{ $profile->social_linkedin }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle p-2" title="LinkedIn"><i class="fa fa-linkedin"></i></a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tab Manajemen Profil & Password (Kanan) -->
            <div class="col-xl-8 col-lg-7">
                <div class="card">
                    <div class="card-header pb-0 border-bottom">
                        <ul class="nav nav-tabs border-tab nav-primary" id="profileTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="profile-info-tab" data-bs-toggle="tab" href="#profile-info" role="tab" aria-controls="profile-info" aria-selected="true">
                                    <i class="fa fa-user me-2"></i> Informasi Profil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                    <i class="fa fa-lock me-2"></i> Keamanan & Ganti Password
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content" id="profileTabContent">

                            <!-- TAB 1: INFORMASI PROFIL -->
                            <div class="tab-pane fade show active" id="profile-info" role="tabpanel" aria-labelledby="profile-info-tab">
                                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <!-- Upload Foto Profil -->
                                        <div class="col-12 mb-4">
                                            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded border">
                                                <img id="avatar-form-preview" src="{{ $user->avatar_url }}" alt="Preview Foto" class="rounded-circle border" width="70" height="70" style="object-fit: cover;">
                                                <div class="flex-grow-1">
                                                    <label class="form-label fw-bold mb-1" for="avatar">Ganti Foto Profil / Avatar</label>
                                                    <input type="file" name="avatar" id="avatar" class="form-control form-control-sm @error('avatar') is-invalid @enderror" accept="image/*" onchange="previewAvatar(this)">
                                                    <small class="text-muted">Format didukung: JPG, PNG, WebP, SVG. Maks 2MB. Disimpan ke tabel profil.</small>
                                                    @error('avatar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Informasi Dasar Akun (Users Table) -->
                                        <div class="col-12 mb-2">
                                            <h6 class="text-primary fw-bold border-bottom pb-2"><i class="fa fa-id-badge me-2"></i> Informasi Akun Login</h6>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="username">Username <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">&#64;</span>
                                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                                            </div>
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="email">Alamat Email <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                            </div>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="phone_number">Nomor Telepon / WhatsApp</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa fa-whatsapp"></i></span>
                                                <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $profile->phone_number) }}" placeholder="+62 812-3456-7890">
                                            </div>
                                            @error('phone_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Informasi Biodata Profil (Profiles Table) -->
                                        <div class="col-12 mt-2 mb-2">
                                            <h6 class="text-primary fw-bold border-bottom pb-2"><i class="fa fa-address-card-o me-2"></i> Biodata Tambahan (Tabel Profil)</h6>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="gender">Jenis Kelamin</label>
                                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="Laki-laki" {{ old('gender', $profile->gender) == 'Laki-laki' || old('gender', $profile->gender) == 'L' || old('gender', $profile->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ old('gender', $profile->gender) == 'Perempuan' || old('gender', $profile->gender) == 'P' || old('gender', $profile->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error('gender')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold" for="birth_date">Tanggal Lahir</label>
                                            <input type="date" name="birth_date" id="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date', $profile->birth_date ? $profile->birth_date->format('Y-m-d') : '') }}">
                                            @error('birth_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold" for="address">Alamat Tempat Tinggal</label>
                                            <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror" placeholder="Alamat lengkap domisili...">{{ old('address', $profile->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label class="form-label fw-bold" for="bio">Bio / Tentang Saya</label>
                                            <textarea name="bio" id="bio" rows="3" class="form-control @error('bio') is-invalid @enderror" placeholder="Tuliskan deskripsi singkat mengenai peran atau keahlian Anda...">{{ old('bio', $profile->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Media Sosial Pengguna -->
                                        <div class="col-12 mt-2 mb-2">
                                            <h6 class="text-primary fw-bold border-bottom pb-2"><i class="fa fa-share-alt me-2"></i> Tautan Media Sosial</h6>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label small fw-bold" for="social_facebook"><i class="fa fa-facebook-square text-primary me-1"></i> Facebook URL</label>
                                            <input type="url" name="social_facebook" id="social_facebook" class="form-control form-control-sm @error('social_facebook') is-invalid @enderror" value="{{ old('social_facebook', $profile->social_facebook) }}" placeholder="https://facebook.com/username">
                                            @error('social_facebook')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label small fw-bold" for="social_instagram"><i class="fa fa-instagram text-danger me-1"></i> Instagram URL</label>
                                            <input type="url" name="social_instagram" id="social_instagram" class="form-control form-control-sm @error('social_instagram') is-invalid @enderror" value="{{ old('social_instagram', $profile->social_instagram) }}" placeholder="https://instagram.com/username">
                                            @error('social_instagram')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label small fw-bold" for="social_twitter"><i class="fa fa-twitter text-info me-1"></i> Twitter / X URL</label>
                                            <input type="url" name="social_twitter" id="social_twitter" class="form-control form-control-sm @error('social_twitter') is-invalid @enderror" value="{{ old('social_twitter', $profile->social_twitter) }}" placeholder="https://twitter.com/username">
                                            @error('social_twitter')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label small fw-bold" for="social_linkedin"><i class="fa fa-linkedin-square text-primary me-1"></i> LinkedIn URL</label>
                                            <input type="url" name="social_linkedin" id="social_linkedin" class="form-control form-control-sm @error('social_linkedin') is-invalid @enderror" value="{{ old('social_linkedin', $profile->social_linkedin) }}" placeholder="https://linkedin.com/in/username">
                                            @error('social_linkedin')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-end border-top pt-3 mt-2">
                                        <button class="btn btn-primary px-4" type="submit">
                                            <i class="fa fa-save me-2"></i> Simpan Perubahan Profil
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- TAB 2: KEAMANAN & GANTI PASSWORD -->
                            <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                                <div class="card-header px-0 pt-0 pb-3 mb-4 border-bottom">
                                    <h5 class="text-primary"><i class="fa fa-key me-2"></i> Perbarui Password Akun</h5>
                                    <p class="text-muted mb-0 small">Pastikan akun Anda menggunakan kombinasi password yang kuat dan aman untuk menjaga privasi data Anda.</p>
                                </div>

                                <div class="alert alert-light-primary border-primary mb-4" role="alert">
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-info-circle fs-4 me-3 text-primary"></i>
                                        <div>
                                            <strong class="d-block">Tips Keamanan Password:</strong>
                                            <span class="small text-muted">Gunakan minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, dan simbol khusus (seperti @, #, $, !).</span>
                                        </div>
                                    </div>
                                </div>

                                <form method="POST" action="{{ route('profile.password') }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold" for="current_password">Password Saat Ini <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fa fa-unlock-alt"></i></span>
                                                    <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan password Anda saat ini" required>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('#current_password')">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('current_password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label fw-bold" for="new_password">Password Baru <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                                    <input type="password" name="password" id="new_password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password baru (minimal 8 karakter)" required>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('#new_password')">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label fw-bold" for="password_confirmation">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fa fa-check"></i></span>
                                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi password baru Anda" required>
                                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('#password_confirmation')">
                                                        <i class="fa fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="text-end border-top pt-3">
                                                <button class="btn btn-primary px-4" type="submit">
                                                    <i class="fa fa-shield me-2"></i> Perbarui Password
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        // Live preview avatar saat file dipilih
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar-form-preview').attr('src', e.target.result);
                    $('#avatar-preview-card').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Toggle password show/hide
        function togglePasswordVisibility(fieldId) {
            const field = $(fieldId);
            const icon = field.siblings('button').find('i');
            if (field.attr('type') === 'password') {
                field.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                field.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        }

        $(document).ready(function() {
            // Auto open tab based on URL hash (e.g. #password)
            let hash = window.location.hash;
            if (hash) {
                let triggerEl = document.querySelector('#profileTab a[href="' + hash + '"]');
                if (triggerEl) {
                    let tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                }
            }

            $('#profileTab a').on('shown.bs.tab', function(e) {
                window.location.hash = e.target.getAttribute('href');
            });
        });
    </script>
@endsection
