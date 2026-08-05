<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    public function run()
    {
        $merchants = [
            [
                'name' => 'متجر الأزياء الفاخرة',
                'email' => 'merchant1@rizk.com',
                'password' => Hash::make('merchant123'),
                'user_type' => 'merchant',
                'is_active' => 1,
                'city' => 'دمشق',
                'store_name' => 'الأزياء الفاخرة',
                'store_description' => 'أحدث صيحات الموضة بأفضل الأسعار',
                'phone' => '+963 955 123 456',
            ],
            [
                'name' => 'متجر الإلكترونيات الحديثة',
                'email' => 'merchant2@rizk.com',
                'password' => Hash::make('merchant123'),
                'user_type' => 'merchant',
                'is_active' => 1,
                'city' => 'حلب',
                'store_name' => 'إلكترونيات حديثة',
                'store_description' => 'أحدث الأجهزة الإلكترونية',
                'phone' => '+963 944 567 890',
            ],
        ];

        foreach ($merchants as $merchant) {
            User::firstOrCreate(
                ['email' => $merchant['email']],
                $merchant
            );
        }
        
        $this->command->info('✅ تم إنشاء التجار بنجاح!');
    }
}
