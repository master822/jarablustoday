<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class SimpleProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            $imageNumber = ($product->id % 10) + 1;
            $product->images = json_encode(['products/product_' . $imageNumber . '.png']);
            $product->save();
            echo "✅ تم تحديث صورة المنتج: {$product->name}\n";
        }
        
        echo "🎉 تم تحديث جميع الصور!\n";
    }
}
