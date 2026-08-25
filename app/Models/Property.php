<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'approved_by',
        'type',
        'title',
        'description',
        'price',
        'city',
        'area',
        'address',
        'rooms',
        'bathrooms',
        'area_m2',
        'building_age',
        'finishing_type',
        'currency',
        'images',
        'status',
        'rejection_reason',
        'approved_at',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'building_age' => 'integer',
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

    public function scopeForSale($query)
    {
        return $query->where('type', 'sale');
    }

    public function scopeForRent($query)
    {
        return $query->where('type', 'rent');
    }
}
