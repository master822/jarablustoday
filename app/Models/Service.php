<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_type',
        'service_name',
        'description',
        'price_type',
        'price',
        'city',
        'is_active',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2'
    ];

    // علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // نطاق للخدمات النشطة
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
