<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Hanya buat akun login — data lainnya diinput manual oleh user.
     */
    public function run(): void
    {
        // Buat User Admin (Pembina UKS)
        User::create([
            'name' => 'Admin Pembina UKS',
            'email' => 'admin@uks.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat User Petugas (Siswa PMR)
        User::create([
            'name' => 'Petugas PMR',
            'email' => 'petugas@uks.test',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);
    }
}
