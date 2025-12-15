<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make(
            $input,
            [
                'username' => [
                    'required',
                    'string',
                    'max:18',
                    'regex:/^[a-z0-9_]+$/',
                    Rule::unique(User::class),
                ],
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'password' => $this->passwordRules(),
            ],
            [
                // USERNAME
                'username.required' => 'Username wajib diisi.',
                'username.string'   => 'Username harus berupa teks.',
                'username.max'      => 'Username maksimal 18 karakter.',
                'username.regex'    => 'Username hanya boleh berisi huruf kecil, angka, dan underscore (_), tanpa spasi.',
                'username.unique'   => 'Username sudah digunakan, silakan pilih yang lain.',

                // NAME
                'name.required' => 'Nama wajib diisi.',
                'name.string'   => 'Nama harus berupa teks.',
                'name.max'      => 'Nama maksimal 255 karakter.',

                // EMAIL
                'email.required' => 'Email wajib diisi.',
                'email.string'   => 'Email harus berupa teks.',
                'email.email'    => 'Format email tidak valid.',
                'email.max'      => 'Email maksimal 255 karakter.',
                'email.unique'   => 'Email sudah terdaftar.',

                // PASSWORD
                'password.regex'    => 'Password tidak boleh mengandung spasi.',
                'password.required'  => 'Password wajib diisi.',
                'password.string'    => 'Password harus berupa teks.',
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.regex'     => 'Password tidak boleh mengandung spasi.',
            ]
        )->validate();

        $user = User::create([
            'username' => $input['username'],
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->assignRole('user');

        return $user;
    }
}
