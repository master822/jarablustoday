<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Discount;
use App\Models\Message;
use App\Models\Rating;
use Illuminate\Support\Facades\Hash;

class RizkDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ============================================
        // 1. إنشاء الفئات (Categories)
        // ============================================
        $categories = [
            ['name' => 'ملابس', 'slug' => 'clothes', 'icon' => 'fa-tshirt', 'description' => 'ملابس رجالية ونسائية وأطفال - أحدث الصيحات', 'is_active' => 1],
            ['name' => 'إلكترونيات', 'slug' => 'electronics', 'icon' => 'fa-mobile-alt', 'description' => 'هواتف، أجهزة كمبيوتر، إكسسوارات، ألعاب', 'is_active' => 1],
            ['name' => 'أدوات منزلية', 'slug' => 'home', 'icon' => 'fa-home', 'description' => 'أثاث، أجهزة منزلية، ديكور، إضاءة', 'is_active' => 1],
            ['name' => 'بقالة', 'slug' => 'food', 'icon' => 'fa-apple-alt', 'description' => 'مواد غذائية، مشروبات، حلويات، بهارات', 'is_active' => 1],
            ['name' => 'سيارات', 'slug' => 'cars', 'icon' => 'fa-car', 'description' => 'سيارات جديدة ومستعملة، قطع غيار', 'is_active' => 1],
            ['name' => 'عقارات', 'slug' => 'real-estate', 'icon' => 'fa-building', 'description' => 'شقق، فلل، أراضي، محلات تجارية', 'is_active' => 1],
            ['name' => 'مستعمل', 'slug' => 'used', 'icon' => 'fa-recycle', 'description' => 'منتجات مستعملة بحالة جيدة', 'is_active' => 1],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // ============================================
        // 2. إنشاء المستخدمين (باستخدام firstOrCreate)
        // ============================================

        // 2.1 المشرف (Admin)
        $admin = User::firstOrCreate(
            ['email' => 'admin@rizk.com'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('admin123'),
                'user_type' => 'admin',
                'is_active' => 1,
                'city' => 'دمشق',
                'phone' => '+963 999 888 777',
            ]
        );

        // 2.2 التجار (Merchants)
        $merchant1 = User::firstOrCreate(
            ['email' => 'merchant1@rizk.com'],
            [
                'name' => 'متجر الأزياء الفاخرة',
                'password' => Hash::make('merchant123'),
                'user_type' => 'merchant',
                'is_active' => 1,
                'city' => 'دمشق',
                'store_name' => 'الأزياء الفاخرة',
                'store_description' => 'أحدث صيحات الموضة بأفضل الأسعار',
                'phone' => '+963 955 123 456',
            ]
        );

        $merchant2 = User::firstOrCreate(
            ['email' => 'merchant2@rizk.com'],
            [
                'name' => 'متجر الإلكترونيات الحديثة',
                'password' => Hash::make('merchant123'),
                'user_type' => 'merchant',
                'is_active' => 1,
                'city' => 'حلب',
                'store_name' => 'إلكترونيات حديثة',
                'store_description' => 'أحدث الأجهزة الإلكترونية والتكنولوجيا',
                'phone' => '+963 944 567 890',
            ]
        );

        $merchant3 = User::firstOrCreate(
            ['email' => 'merchant3@rizk.com'],
            [
                'name' => 'متجر الأثاث المنزلي',
                'password' => Hash::make('merchant123'),
                'user_type' => 'merchant',
                'is_active' => 1,
                'city' => 'حمص',
                'store_name' => 'أثاث منزلي راقي',
                'store_description' => 'أثاث فاخر وديكورات عصرية',
                'phone' => '+963 933 789 012',
            ]
        );

        $merchant4 = User::firstOrCreate(
            ['email' => 'merchant4@rizk.com'],
            [
                'name' => 'متجر السيارات المميزة',
                'password' => Hash::make('merchant123'),
                'user_type' => 'merchant',
                'is_active' => 1,
                'city' => 'اللاذقية',
                'store_name' => 'سيارات مميزة',
                'store_description' => 'سيارات جديدة ومستعملة بأسعار مناسبة',
                'phone' => '+963 922 345 678',
            ]
        );

        $merchant5 = User::firstOrCreate(
            ['email' => 'merchant5@rizk.com'],
            [
                'name' => 'متجر البقالة الذكية',
                'password' => Hash::make('merchant123'),
                'user_type' => 'merchant',
                'is_active' => 1,
                'city' => 'حماة',
                'store_name' => 'بقالة ذكية',
                'store_description' => 'أفضل المواد الغذائية والمنتجات الطازجة',
                'phone' => '+963 911 234 567',
            ]
        );

        // 2.3 المستخدمين العاديين (Users)
        $user1 = User::firstOrCreate(
            ['email' => 'user1@rizk.com'],
            [
                'name' => 'أحمد خالد',
                'password' => Hash::make('user123'),
                'user_type' => 'user',
                'is_active' => 1,
                'city' => 'دمشق',
                'phone' => '+963 988 777 666',
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'user2@rizk.com'],
            [
                'name' => 'سارة علي',
                'password' => Hash::make('user123'),
                'user_type' => 'user',
                'is_active' => 1,
                'city' => 'حلب',
                'phone' => '+963 977 666 555',
            ]
        );

        $user3 = User::firstOrCreate(
            ['email' => 'user3@rizk.com'],
            [
                'name' => 'محمد حسن',
                'password' => Hash::make('user123'),
                'user_type' => 'user',
                'is_active' => 1,
                'city' => 'حمص',
                'phone' => '+963 966 555 444',
            ]
        );

        // ============================================
        // 3. إنشاء المستخدمين المزودين للخدمات
        // ============================================
        $service_providers = [
            ['email' => 'cooking@rizk.com', 'name' => 'طبخ منزل - أميرة', 'store_name' => 'مطبخ أميرة', 'store_description' => 'أشهى الأطباق المنزلية بلمسة أميرة', 'phone' => '+963 944 123 456'],
            ['email' => 'vegetables@rizk.com', 'name' => 'خضار مقطعة - خضارك', 'store_name' => 'خضارك الطازجة', 'store_description' => 'خضار طازجة مقطعة وجاهزة للطبخ', 'phone' => '+963 955 234 567'],
            ['email' => 'transport@rizk.com', 'name' => 'سيارة نقل - سريع', 'store_name' => 'نقل سريع', 'store_description' => 'خدمة نقل سريعة وآمنة لجميع أنحاء المدينة', 'phone' => '+963 966 345 678'],
            ['email' => 'jobs@rizk.com', 'name' => 'فرص عمل - وظيفتك', 'store_name' => 'وظيفتك', 'store_description' => 'أفضل فرص العمل في مختلف المجالات', 'phone' => '+963 977 456 789'],
            ['email' => 'hire-worker@rizk.com', 'name' => 'استأجر عامل - عامل مثالي', 'store_name' => 'عامل مثالي', 'store_description' => 'أفضل العمال المهرة بأسعار تنافسية', 'phone' => '+963 988 567 890'],
            ['email' => 'hire-technician@rizk.com', 'name' => 'استأجر فني - فني متخصص', 'store_name' => 'فني متخصص', 'store_description' => 'فنيين متخصصين في جميع المجالات مع ضمان الجودة', 'phone' => '+963 999 678 901'],
        ];

        foreach ($service_providers as $provider) {
            User::firstOrCreate(
                ['email' => $provider['email']],
                [
                    'name' => $provider['name'],
                    'password' => Hash::make('service123'),
                    'user_type' => 'merchant',
                    'is_active' => 1,
                    'city' => 'دمشق',
                    'store_name' => $provider['store_name'],
                    'store_description' => $provider['store_description'],
                    'phone' => $provider['phone'],
                ]
            );
        }

        // ============================================
        // عرض معلومات المستخدمين
        // ============================================
        $this->command->info('✅ تم إنشاء جميع البيانات بنجاح!');
        $this->command->info('');
        $this->command->info('============= 👤 بيانات المستخدمين =============');
        $this->command->info('');
        $this->command->info('🛡️  المشرف (Admin):');
        $this->command->info('   📧 admin@rizk.com');
        $this->command->info('   🔑 admin123');
        $this->command->info('');
        $this->command->info('🏪 التجار (Merchants):');
        $this->command->info('   📧 merchant1@rizk.com  |  🔑 merchant123  (ملابس)');
        $this->command->info('   📧 merchant2@rizk.com  |  🔑 merchant123  (إلكترونيات)');
        $this->command->info('   📧 merchant3@rizk.com  |  🔑 merchant123  (أثاث)');
        $this->command->info('   📧 merchant4@rizk.com  |  🔑 merchant123  (سيارات)');
        $this->command->info('   📧 merchant5@rizk.com  |  🔑 merchant123  (بقالة)');
        $this->command->info('');
        $this->command->info('👤 المستخدمين العاديين (Users):');
        $this->command->info('   📧 user1@rizk.com  |  🔑 user123');
        $this->command->info('   📧 user2@rizk.com  |  🔑 user123');
        $this->command->info('   📧 user3@rizk.com  |  🔑 user123');
        $this->command->info('');
        $this->command->info('🛎️  مزودي الخدمات (Service Providers):');
        $this->command->info('   📧 cooking@rizk.com         |  🔑 service123  (طبخ منزل)');
        $this->command->info('   📧 vegetables@rizk.com      |  🔑 service123  (خضار مقطعة)');
        $this->command->info('   📧 transport@rizk.com       |  🔑 service123  (سيارة نقل)');
        $this->command->info('   📧 jobs@rizk.com            |  🔑 service123  (فرص عمل)');
        $this->command->info('   📧 hire-worker@rizk.com     |  🔑 service123  (استأجر عامل)');
        $this->command->info('   📧 hire-technician@rizk.com |  🔑 service123  (استأجر فني)');
        $this->command->info('');
        $this->command->info('=================================================');
    }
}
