<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$products = App\Models\Product::all();
foreach ($products as $index => $product) {
    $imageNumber = ($index % 10) + 1;
    $product->images = json_encode(['products/product_' . $imageNumber . '.png']);
    $product->save();
    echo "✅ تم تحديث: " . $product->name . "\n";
}
echo "🎉 تم تحديث " . $products->count() . " منتج!\n";
