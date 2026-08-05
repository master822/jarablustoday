<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

// حذف أي مسؤول موجود مسبقاً
User::where('user_type', 'admin')->delete();

// إنشاء مسؤول جديد
$admin = User::create([
    'name' => 'مدير النظام',
    'email' => 'admin@rizk.com',
    'password' => bcrypt('admin123'),
    'user_type' => 'admin',
    'is_active' => 1,
    'city' => 'دمشق',
    'phone' => '+963 999 888 777',
]);

echo "✅ تم إنشاء المسؤول بنجاح!\n";
echo "📧 البريد الإلكتروني: admin@rizk.com\n";
echo "🔑 كلمة المرور: admin123\n";
echo "👤 الاسم: " . $admin->name . "\n";
