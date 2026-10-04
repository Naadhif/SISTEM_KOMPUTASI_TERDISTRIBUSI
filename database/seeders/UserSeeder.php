<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@storeta.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        // Seller users
        User::create([
            'name' => 'Seller One',
            'email' => 'seller1@storeta.com',
            'password' => bcrypt('password123'),
            'role' => 'seller'
        ]);

        User::create([
            'name' => 'Seller Two',
            'email' => 'seller2@storeta.com',
            'password' => bcrypt('password123'),
            'role' => 'seller'
        ]);

        // Regular users
        User::create([
            'name' => 'Regular User',
            'email' => 'user@storeta.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Buyer One',
            'email' => 'buyer1@storeta.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);
    }
}
