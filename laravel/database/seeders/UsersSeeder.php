<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'phone' => '0999000001',
            'role' => 'admin',
            'password' => bcrypt('admin1234'),
            'is_approved' =>
            true,
        ]);

        User::create([
            'name' => 'Vendor User',
            'email' => 'vendor@example.com',
            'phone' => '0999000002',
            'role' => 'vendor',
            'password' => bcrypt('vendor1234'),
            'is_approved' => true,
        ]);

        User::create([
            'name' => 'Driver User',
            'email' => 'driver@example.com',
            'phone' => '0999000003',
            'role' => 'driver',
            'password' => bcrypt('driver1234'),
            'is_approved' => true,
        ]);
    }
}
