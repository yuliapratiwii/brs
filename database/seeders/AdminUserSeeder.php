<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@brs.local'],
            [
                'name' => 'Admin BRS',
                'password' => Hash::make('1674admin'),
                'email_verified_at' => now(),
            ]
        );
    }
}