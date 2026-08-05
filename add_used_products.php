<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\Product;
use App\Models\Category;

// التحقق من وجود مستخدم عادي
$user = User::where('user_type', 'user')->first();

if (!$user) {
    $user = User::create([
        'name' => 'مستخدم تجريبي',
        'email' => 'test_user@rizk.com',
        'password' => bcrypt('password123'),
        'user_type' => 'user',
        'is_active' => 1,
        'city' => 'دمشق',
        'phone' => '+963999123456',
    ]);
    echo "✅ تم إنشاء مستخدم عادي: " . $user->name . "\n";
} else {
    echo "✅ المستخدم العادي موجود: " . $user->name . "\n";
}

// الحصول على فئة افتراضية (أول فئة في قاعدة البيانات)
$category = Category::first();
if (!$category) {
    // إنشاء فئة افتراضية إذا لم توجد
    $category = Category::create([
        'name' => 'منتجات عامة',
        'slug' => 'general',
        'is_active' => 1,
    ]);
    echo "✅ تم إنشاء فئة افتراضية: " . $category->name . "\n";
} else {
    echo "✅ الفئة موجودة: " . $category->name . "\n";
}

// قائمة المنتجات المستعملة
$usedProducts = [
    ['هاتف ذكي مستعمل', 'هاتف ذكي بحالة جيدة جداً، يعمل بكفاءة', 150.00],
    ['طاولة كمبيوتر مستعملة', 'طاولة كمبيوتر بحالة ممتازة، مع أدراج', 75.00],
    ['دراجة هوائية مستعملة', 'دراجة هوائية بحالة جيدة، مناسبة للتنقل', 120.00],
    ['غسالة مستعملة', 'غسالة أوتوماتيك بحالة جيدة', 200.00],
    ['ثلاجة مستعملة', 'ثلاجة كبيرة بحالة ممتازة', 300.00],
    ['تلفزيون مستعمل', 'تلفزيون بشاشة كبيرة مع الريموت', 250.00],
    ['مكيف هواء مستعمل', 'مكيف بارد وساخن بحالة جيدة', 350.00],
    ['أريكة مستعملة', 'أريكة 3 مقاعد قماش متين', 180.00],
    ['طاولة طعام مستعملة', 'طاولة طعام مع 4 كراسي خشب طبيعي', 150.00],
    ['خزانة ملابس مستعملة', 'خزانة ملابس بأبواب مرايا بحالة جيدة', 220.00],
];

foreach ($usedProducts as $productData) {
    $existing = Product::where('name', $productData[0])->first();
    if (!$existing) {
        $product = Product::create([
            'name' => $productData[0],
            'description' => $productData[1],
            'price' => $productData[2],
            'condition' => 'used',
            'status' => 'active',
            'user_id' => $user->id,
            'is_used' => true,
            'category_id' => $category->id,
            'images' => json_encode(['products/product_1.png']),
        ]);
        echo "✅ تم إنشاء منتج مستعمل: " . $product->name . "\n";
    } else {
        echo "⚠️ المنتج موجود مسبقاً: " . $productData[0] . "\n";
    }
}

echo "\n🎉 تم إضافة جميع المنتجات المستعملة!\n";
