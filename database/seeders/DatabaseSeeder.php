<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua yang berhubungan dengan factory User
        // karena tabel users kamu tidak pakai kolom "name"
        
   
    $this->call(UserSeeder::class);
}

    }

