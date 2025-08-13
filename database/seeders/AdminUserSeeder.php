<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'chep@gmail.com'],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
    }
}
