<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commentable_id',
        'commentable_type',
        'comment',
        'status',
        'moderation_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
