<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin Laundry',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);
        
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@laundry.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir'
        ]);
    }
}