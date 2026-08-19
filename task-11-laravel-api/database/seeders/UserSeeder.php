<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'User A',
            'email' => 'usera@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'User B',
            'email' => 'userb@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
