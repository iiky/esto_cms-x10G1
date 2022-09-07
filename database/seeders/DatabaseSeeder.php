<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolePermissionSeeder::class);

        $admin = User::create([
            'username' => 'iiky',
            'name' => 'Ahmad Rizki Saefuddin',
            'email' => 'ahmad.rizki.s@gmail.com',
            'email_verified_at' => '2022-08-16 20:57:19',
            'password' => Hash::make('#3st0CM5#')
        ]);

        $admin->assignRole('Super Admin');
    }
}
