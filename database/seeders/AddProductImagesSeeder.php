<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AddProductImagesSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        
        foreach ($products as $product) {
            $imageName = 'products/' . uniqid() . '.png';
            
            // استخدام مكتبة GD لإنشاء صورة
            $image = imagecreate(300, 200);
            
            // تحديد الألوان
            $gold = imagecolorallocate($image, 212, 175, 55);
            $white = imagecolorallocate($image, 255, 255, 255);
            $dark = imagecolorallocate($image, 30, 30, 30);
            
            // تعيين الخلفية
            imagefill($image, 0, 0, $gold);
            
            // رسم مستطيل داخلي
            imagerectangle($image, 10, 10, 289, 189, $dark);
            
            // كتابة اسم المنتج
            $text = mb_substr($product->name, 0, 10);
            if (function_exists('imagettftext')) {
                $font = '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf';
                if (file_exists($font)) {
                    imagettftext($image, 16, 0, 50, 100, $white, $font, $text);
                } else {
                    imagestring($image, 5, 50, 100, $text, $white);
                }
            } else {
                imagestring($image, 5, 50, 100, $text, $white);
            }
            
            // حفظ الصورة
            ob_start();
            imagepng($image);
            $imageData = ob_get_clean();
            Storage::disk('public')->put($imageName, $imageData);
            imagedestroy($image);
            
            // حفظ الصورة في المنتج
            $product->images = json_encode([$imageName]);
            $product->save();
            
            $this->command->info("✅ تم إضافة صورة للمنتج: {$product->name}");
        }
        
        $this->command->info('🎉 تم إضافة الصور لجميع المنتجات!');
    }
}
