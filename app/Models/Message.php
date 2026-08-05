<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    /**
     * مزامنة الحقلين message و content تلقائياً قبل الحفظ لتجنب أي خطأ NOT NULL
     */
    protected static function booted()
    {
        static::saving(function ($model) {
            $text = $model->content ?? $model->message ?? '';
            $model->content = $text;
            $model->message = $text;
        });
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
