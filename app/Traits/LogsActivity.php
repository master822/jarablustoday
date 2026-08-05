<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            Log::info('تم الإنشاء', [
                'model' => get_class($model),
                'id' => $model->id,
                'user_id' => Auth::id(),
                'data' => $model->toArray(),
            ]);
        });

        static::updated(function ($model) {
            Log::info('تم التحديث', [
                'model' => get_class($model),
                'id' => $model->id,
                'user_id' => Auth::id(),
                'changes' => $model->getDirty(),
            ]);
        });

        static::deleted(function ($model) {
            Log::info('تم الحذف', [
                'model' => get_class($model),
                'id' => $model->id,
                'user_id' => Auth::id(),
                'data' => $model->toArray(),
            ]);
        });
    }
}
