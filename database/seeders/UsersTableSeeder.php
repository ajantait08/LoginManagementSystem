<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin@123'), // Hashed password
            'role' => 'admin', // Assuming you have a role field
            'device_token' => null, // Initial value for device token
            'last_login' => null,   // Initial value for last login
        ]);

        User::create([
            'name' => 'User One',
            'email' => 'user1@example.com',
            'password' => Hash::make('user1@123'), // Hashed password
            'role' => 'user', // Normal user role
            'device_token' => null, // Initial value for device token
            'last_login' => null,   // Initial value for last login
        ]);

        User::create([
            'name' => 'User Two',
            'email' => 'user2@example.com',
            'password' => Hash::make('user2@123'), // Hashed password
            'role' => 'user', // Normal user role
            'device_token' => null, // Initial value for device token
            'last_login' => null,   // Initial value for last login
        ]);
    }
}
