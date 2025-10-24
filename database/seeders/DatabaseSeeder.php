<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@alumni.com',
            'password' => Hash::make('password123'),
        ]);

        // Create test user
        User::create([
            'name' => 'Test User',
            'email' => 'test@alumni.com',
            'password' => Hash::make('password123'),
        ]);

        // Seed alumni data
        $this->call([
            AlumniSeeder::class,
        ]);
    }
}