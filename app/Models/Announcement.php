<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'approved_by',
        'title',
        'content',
        'image',
        'phone',
        'city',
        'status',
        'rejection_reason',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function likes()
    {
        return $this->morphMany(ContentLike::class, 'likeable');
    }

    public function comments()
    {
        return $this->morphMany(ContentComment::class, 'commentable');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
