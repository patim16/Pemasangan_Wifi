<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'no_hp' => '08123456789',
            'alamat' => 'Indonesia',
            'role' => 'superadmin',
            'foto_ktp' => null,         // atau kosong
        ]);
    }
}
