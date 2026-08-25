<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'مسؤول النظام',
                'password' => Hash::make('password'),
                'user_type' => 'admin',
                'phone' => '0912345678',
                'city' => 'دمشق',
                'is_active' => true,
            ]
        );

        $this->command->info('Admin account created/updated successfully.');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
    }
}
