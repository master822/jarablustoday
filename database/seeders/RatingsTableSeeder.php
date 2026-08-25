<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rating;

class RatingsTableSeeder extends Seeder
{
    public function run()
    {
        Rating::query()->delete();

        $merchants = User::where('user_type', 'merchant')->get();
        $users = User::where('user_type', 'user')->get();

        if ($merchants->isEmpty()) {
            $this->command->warn('⚠️ لا يوجد تجار.');
            return;
        }

        if ($users->count() < 3) {
            $this->command->warn('⚠️ يجب أن يوجد 3 مستخدمين عاديين على الأقل.');
            return;
        }

        foreach ($merchants as $index => $merchant) {
            if ($index === 0) {
                $ratings = [
                    [
                        'user_id' => $users[0]->id,
                        'rating' => 5,
                        'comment' => 'تاجر ممتاز ومنتجات أصلية، شكراً لك',
                        'is_approved' => true,
                        'is_flagged' => false,
                        'moderation_reason' => null,
                    ],
                    [
                        'user_id' => $users[1]->id,
                        'rating' => 4,
                        'comment' => 'جيد ولكن يمكن تحسين وقت التوصيل',
                        'is_approved' => true,
                        'is_flagged' => false,
                        'moderation_reason' => null,
                    ],
                    [
                        'user_id' => $users[2]->id,
                        'rating' => 5,
                        'comment' => 'خدمة رائعة وأسعار منافسة',
                        'is_approved' => true,
                        'is_flagged' => false,
                        'moderation_reason' => null,
                    ],
                ];
            } else {
                $ratings = [
                    [
                        'user_id' => $users[0]->id,
                        'rating' => 4,
                        'comment' => 'منتجات جيدة وأسعار معقولة',
                        'is_approved' => true,
                        'is_flagged' => false,
                        'moderation_reason' => null,
                    ],
                    [
                        'user_id' => $users[1]->id,
                        'rating' => 5,
                        'comment' => 'أفضل تاجر في المنطقة',
                        'is_approved' => true,
                        'is_flagged' => false,
                        'moderation_reason' => null,
                    ],
                ];
            }

            foreach ($ratings as $data) {
                Rating::create([
                    'user_id' => $data['user_id'],
                    'merchant_id' => $merchant->id,
                    'rating' => $data['rating'],
                    'comment' => $data['comment'],
                    'is_approved' => $data['is_approved'],
                    'is_flagged' => $data['is_flagged'],
                    'moderation_reason' => $data['moderation_reason'],
                ]);
            }
        }

        $this->command->info('✅ تم إنشاء التقييمات بنجاح!');
        $this->command->info('📊 إجمالي التقييمات: ' . Rating::count());
    }
}
