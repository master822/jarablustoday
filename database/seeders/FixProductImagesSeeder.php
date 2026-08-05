<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class FixProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            // استخدام صور من picsum.photos
            $imageUrl = 'https://picsum.photos/seed/' . $product->id . '/300/200';
            
            try {
                $contents = @file_get_contents($imageUrl);
                if ($contents) {
                    $imageName = 'products/' . uniqid() . '.jpg';
                    Storage::disk('public')->put($imageName, $contents);
                    
                    $product->images = json_encode([$imageName]);
                    $product->save();
                    
                    $this->command->info("✅ تم إضافة صورة للمنتج: {$product->name}");
                } else {
                    $this->command->warn("⚠️ فشل تحميل صورة للمنتج: {$product->name}");
                }
            } catch (\Exception $e) {
                $this->command->warn("⚠️ خطأ في المنتج: {$product->name}");
            }
        }
        
        $this->command->info('🎉 تم إضافة الصور للمنتجات!');
    }
}
