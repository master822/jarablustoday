<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rating;

class RatingsTableSeeder extends Seeder
{
    public function run()
    {
        // حذف التقييمات القديمة
        Rating::query()->delete();

        // الحصول على التاجر الأساسي
        $merchant = User::where('email', 'merchant@example.com')
            ->where('user_type', 'merchant')
            ->first();

        // الحصول على المستخدم الأساسي
        $user = User::where('email', 'user@example.com')
            ->where('user_type', 'user')
            ->first();

        // التأكد من وجود البيانات المطلوبة
        if (!$merchant) {
            $this->command->warn(
                '⚠️ لم يتم العثور على merchant@example.com'
            );

            return;
        }

        if (!$user) {
            $this->command->warn(
                '⚠️ لم يتم العثور على user@example.com'
            );

            return;
        }

        /*
         * التقييمات الخاصة بالتاجر الأساسي
         *
         * نستخدم IDs الحقيقية التي تم إنشاؤها أثناء التشغيل،
         * ولا نعتمد على رقم ID ثابت.
         */

        Rating::create([
            'user_id' => $user->id,
            'merchant_id' => $merchant->id,
            'rating' => 5,
            'comment' => 'تاجر ممتاز ومنتجات أصلية، شكراً لك',
            'is_approved' => true,
            'is_flagged' => false,
            'moderation_reason' => null,
        ]);

        Rating::create([
            'user_id' => $user->id,
            'merchant_id' => $merchant->id,
            'rating' => 4,
            'comment' => 'جيد ولكن يمكن تحسين وقت التوصيل',
            'is_approved' => true,
            'is_flagged' => false,
            'moderation_reason' => null,
        ]);

        Rating::create([
            'user_id' => $user->id,
            'merchant_id' => $merchant->id,
            'rating' => 5,
            'comment' => 'خدمة رائعة وأسعار منافسة',
            'is_approved' => true,
            'is_flagged' => false,
            'moderation_reason' => null,
        ]);

        // تقييم مرفوض/معلّم لاختبار نظام الإشراف
        Rating::create([
            'user_id' => $user->id,
            'merchant_id' => $merchant->id,
            'rating' => 1,
            'comment' => 'تقييم تجريبي يحتاج إلى مراجعة',
            'is_approved' => false,
            'is_flagged' => true,
            'moderation_reason' => 'تم وضع التقييم للمراجعة',
        ]);

        $this->command->info(
            '✅ تم إنشاء التقييمات بنجاح!'
        );

        $this->command->info(
            '📊 إجمالي التقييمات: ' . Rating::count()
        );
    }
}