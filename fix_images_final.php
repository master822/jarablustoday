<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$products = App\Models\Product::all();
foreach ($products as $product) {
    $product->images = json_encode(['https://picsum.photos/seed/' . $product->id . '/300/200']);
    $product->save();
    echo "✅ تم تحديث: {$product->name}\n";
}
echo "🎉 تم تحديث جميع المنتجات!\n";
