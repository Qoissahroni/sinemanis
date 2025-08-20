<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sinemanis.ac.id',
            'phone' => '081234567890',
            'role' => 'admin',
            'password' => Hash::make('admin123456'),
        ]);
    }
}