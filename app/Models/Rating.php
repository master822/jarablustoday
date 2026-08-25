<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'merchant_id',
        'product_id',
        'rating',
        'comment',
        'is_approved',
        'is_flagged',
        'moderation_reason',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'is_flagged' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function merchant()
    {
        return $this->belongsTo(User::class, 'merchant_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    public function scopeActive($query)
    {
        return $query
            ->where('is_approved', true)
            ->where('is_flagged', false);
    }
}
