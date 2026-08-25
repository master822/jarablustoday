<?php

namespace App\Console\Commands;

use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteExpiredNews extends Command
{
    protected $signature = 'news:delete-expired';

    protected $description = 'Delete approved news older than 48 hours';

    public function handle(): int
    {
        $news = News::where('status', 'approved')
            ->whereNotNull('approved_at')
            ->where('approved_at', '<=', now()->subHours(48))
            ->get();

        $count = 0;

        foreach ($news as $item) {
            DB::transaction(function () use ($item) {

                // حذف التعليقات المرتبطة بالخبر
                $item->comments()->delete();

                // حذف الإعجابات المرتبطة بالخبر
                $item->likes()->delete();

                // حذف صورة الخبر من التخزين
                if ($item->image) {
                    Storage::disk('public')->delete($item->image);
                }

                // حذف الخبر نهائياً
                $item->delete();
            });

            $count++;
        }

        $this->info("Deleted {$count} expired news item(s).");

        return self::SUCCESS;
    }
}
