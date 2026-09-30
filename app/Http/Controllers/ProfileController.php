<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil dan pengaturan password.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone_number' => null,
                'bio'          => null,
                'address'      => null,
                'gender'       => null,
                'birth_date'   => null,
            ]
        );

        return view('profile.index', compact('user', 'profile'));
    }

    /**
     * Perbarui data profil pengguna dan data tabel profiles.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'username'         => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'email'            => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number'     => ['nullable', 'string', 'max:30'],
            'birth_date'       => ['nullable', 'date'],
            'gender'           => ['nullable', 'string', 'in:Laki-laki,Perempuan,L,P,male,female'],
            'address'          => ['nullable', 'string', 'max:500'],
            'bio'              => ['nullable', 'string', 'max:1000'],
            'avatar'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'social_facebook'  => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_twitter'   => ['nullable', 'url', 'max:255'],
            'social_linkedin'  => ['nullable', 'url', 'max:255'],
        ], [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username ini sudah digunakan oleh akun lain.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email ini sudah terdaftar.',
            'avatar.image'      => 'Foto profil harus berupa file gambar.',
            'avatar.max'        => 'Ukuran foto profil maksimal 2MB.',
        ]);

        // Simpan data ke tabel users
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];

        // Dapatkan atau inisialisasi tabel profile
        $profile = Profile::firstOrNew(['user_id' => $user->id]);
        $profile->phone_number = $validated['phone_number'] ?? null;
        $profile->birth_date = $validated['birth_date'] ?? null;
        $profile->gender = $validated['gender'] ?? null;
        $profile->address = $validated['address'] ?? null;
        $profile->bio = $validated['bio'] ?? null;
        $profile->social_facebook = $validated['social_facebook'] ?? null;
        $profile->social_instagram = $validated['social_instagram'] ?? null;
        $profile->social_twitter = $validated['social_twitter'] ?? null;
        $profile->social_linkedin = $validated['social_linkedin'] ?? null;

        // Upload avatar jika ada
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $profile->avatar = $avatarPath;
            $user->foto = $avatarPath;
        }

        $user->save();
        $profile->save();

        return redirect()->route('profile.index')->with('success', 'Data profil berhasil diperbarui!');
    }

    /**
     * Perbarui password akun pengguna.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password:web'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required'         => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini yang Anda masukkan salah.',
            'password.required'                 => 'Password baru wajib diisi.',
            'password.min'                      => 'Password baru minimal 8 karakter.',
            'password.confirmed'                => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.index', ['#password'])->with('success', 'Password akun Anda berhasil diperbarui!');
    }
}
