<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$products = App\Models\Product::all();
$existingImages = glob(storage_path('app/public/products/*.png'));
$imageFiles = array_filter($existingImages, function($file) {
    return strpos($file, 'default') === false;
});
$imageFiles = array_values($imageFiles);

foreach ($products as $index => $product) {
    if (count($imageFiles) > 0) {
        $file = $imageFiles[$index % count($imageFiles)];
        $fileName = basename($file);
        $product->images = json_encode(['products/' . $fileName]);
        $product->save();
        echo "✅ تم تحديث: " . $product->name . "\n";
    }
}
echo "🎉 تم تحديث جميع المنتجات!\n";
