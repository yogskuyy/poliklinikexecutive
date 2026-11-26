<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@poliklinik.com'],
            [
                'name' => 'Administrator Eksekutif',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        // Regular User / Staff Account
        User::updateOrCreate(
            ['email' => 'user@poliklinik.com'],
            [
                'name' => 'Staff Layanan Informasi',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );
    }
}
