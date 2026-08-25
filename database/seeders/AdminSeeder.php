<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $masterAdminEmail = 'mastersniper822@gmail.com';

        $admin = User::updateOrCreate(
            ['email' => $masterAdminEmail],
            [
                'name' => 'Muhammad Admin',
                'password' => Hash::make('sniper927MUHAMMAD'),
                'user_type' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // ضمان وجود Admin واحد فقط
        User::where('user_type', 'admin')
            ->where('id', '!=', $admin->id)
            ->update([
                'user_type' => 'user',
            ]);

        $this->command->info('Master Admin account created/updated successfully.');
        $this->command->info('Email: ' . $masterAdminEmail);
    }
}
