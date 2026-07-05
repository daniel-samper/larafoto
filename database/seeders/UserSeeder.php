<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default admin user
        User::create([
            'role' => 'admin',
            'name' => 'Admin',
            'surname' => 'User',
            'nick' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create a regular user
        User::create([
            'role' => 'user',
            'name' => 'John',
            'surname' => 'Doe',
            'nick' => 'johndoe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create a few more sample users using the factory
        // We'll create them manually to avoid email_verified_at field issues
        for ($i = 0; $i < 5; $i++) {
            User::create([
                'role' => 'user',
                'name' => fake()->name(),
                'surname' => fake()->lastName(),
                'nick' => fake()->unique()->userName(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
            ]);
        }
    }
}
