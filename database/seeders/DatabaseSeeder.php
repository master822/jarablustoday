<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Rating;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        echo "🔧 بدء إعداد قاعدة البيانات...\n";

        // تعطيل فحص المفاتيح الأجنبية مؤقتاً
        Schema::disableForeignKeyConstraints();
        
        // تنظيف الجداول بشكل آمن
        $tables = ['ratings', 'products', 'categories', 'users'];
        
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->delete();
                echo "✅ تم تنظيف جدول: {$table}\n";
            }
        }
        
        // إعادة تعيين Auto Increment لقاعدة بيانات SQLite
        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                try {
                    DB::statement("DELETE FROM sqlite_sequence WHERE name='{$table}'");
                } catch (\Exception $e) {
                    // تجاهل الخطأ إذا لم يكن الجدول موجوداً في sqlite_sequence
                }
            }
        }
        
        Schema::enableForeignKeyConstraints();

        // إضافة التصنيفات أولاً (مهم للمنتجات)
        if (class_exists(\Database\Seeders\CategorySeeder::class)) {
            $this->call(CategorySeeder::class);
        }
        
        // إضافة المستخدمين الأساسيين (من ضمنهم الأدمن)
        $this->createBasicUsers();
        

        // مستخدمون تجريبيون للتقييمات
        $demoUsers = [
            [
                'name' => 'مستخدم 1',
                'email' => 'user1@rizk.com',
                'password' => Hash::make('user123'),
                'user_type' => 'user',
                'phone' => '+963988777666',
                'city' => 'دمشق',
                'is_active' => true,
            ],
            [
                'name' => 'مستخدم 2',
                'email' => 'user2@rizk.com',
                'password' => Hash::make('user123'),
                'user_type' => 'user',
                'phone' => '+963977666555',
                'city' => 'حلب',
                'is_active' => true,
            ],
            [
                'name' => 'مستخدم 3',
                'email' => 'user3@rizk.com',
                'password' => Hash::make('user123'),
                'user_type' => 'user',
                'phone' => '+963966555444',
                'city' => 'حمص',
                'is_active' => true,
            ],
        ];

        foreach ($demoUsers as $demoUser) {
            User::updateOrCreate(
                ['email' => $demoUser['email']],
                $demoUser
            );
        }

        echo "✅ تم إضافة 3 مستخدمين تجريبيين للتقييمات\n";

        // إضافة المنتجات
        if (class_exists(\Database\Seeders\ProductSeeder::class)) {
            $this->call(ProductSeeder::class);
        }
        
        // إضافة التخفيضات
        if (class_exists(\Database\Seeders\DiscountSeeder::class)) {
            $this->call(DiscountSeeder::class);
        }
        
        // إضافة التقييمات
        if (class_exists(\Database\Seeders\RatingsTableSeeder::class)) {
            $this->call(RatingsTableSeeder::class);
        }

        echo "🎉 تم إعداد قاعدة البيانات بنجاح!\n";
    }

    private function createBasicUsers()
    {
        // استخدام updateOrCreate لمنع التكرار في حال إعادة التشغيل
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

        User::updateOrCreate(
            ['email' => 'merchant@example.com'],
            [
                'name' => 'أحمد التاجر',
                'password' => Hash::make('password'),
                'user_type' => 'merchant',
                'phone' => '0912345679',
                'city' => 'دمشق',
                'store_name' => 'متجر أحمد للإلكترونيات',
                'store_category' => 'electronics',
                'store_description' => 'متخصص في بيع الأجهزة الإلكترونية والهواتف الذكية',
                'store_phone' => '0912345679',
                'store_city' => 'دمشق',
                'product_limit' => 10,
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'مستخدم عادي',
                'password' => Hash::make('password'),
                'user_type' => 'user',
                'phone' => '0912345680',
                'city' => 'دمشق',
                'product_limit' => 5,
                'is_active' => true,
            ]
        );

        echo "✅ تم إضافة المستخدمين الأساسيين بنجاح\n";
    }
}