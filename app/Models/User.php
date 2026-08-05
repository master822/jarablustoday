<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'phone',
        'city',
        'is_active',
        'store_name',
        'store_category',
        'store_description',
        'store_phone',
        'store_city',
        'product_limit',
        'avatar',
        'store_logo',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function isMerchant()
    {
        return $this->user_type === 'merchant';
    }

    public function isUser()
    {
        return $this->user_type === 'user';
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isServiceProvider()
    {
        $serviceTypes = [
            'cooking', 'vegetables', 'transport', 'worker', 
            'technician', 'programmer', 'designer', 'photographer',
            'translator', 'tutor', 'cleaner', 'gardener',
            'electrician', 'plumber', 'carpenter', 'painter',
            'hairdresser', 'tailor', 'mechanic', 'driver',
            'security', 'nurse', 'teacher', 'engineer',
            'architect', 'accountant', 'lawyer', 'consultant',
            'cleaning_company', 'carpet_cleaner'
        ];
        return in_array($this->user_type, $serviceTypes);
    }

    public function canPostJobs()
    {
        return $this->isMerchant() || $this->isServiceProvider();
    }

    public function canSellUsed()
    {
        return $this->isUser();
    }

    public function getTrialDaysLeftAttribute()
    {
        if (!$this->created_at) {
            return 0;
        }
        $trialEnd = $this->created_at->addMonths(4);
        $days = now()->diffInDays($trialEnd, false);
        return max(0, (int) ceil($days));
    }

    public function isOnTrial()
    {
        return $this->getTrialDaysLeftAttribute() > 0;
    }

    public function getSubscriptionStatus()
    {
        $subscription = Subscription::where('user_id', $this->id)
                                    ->where('status', 'active')
                                    ->first();
        
        if ($subscription && $subscription->isActive()) {
            return [
                'status' => 'active',
                'plan' => $subscription->plan,
                'product_limit' => $subscription->product_limit,
                'end_date' => $subscription->end_date,
                'days_left' => now()->diffInDays($subscription->end_date, false),
            ];
        }
        
        if ($this->isOnTrial()) {
            return [
                'status' => 'trial',
                'plan' => 'trial',
                'product_limit' => 25,
                'end_date' => $this->created_at->addMonths(4),
                'days_left' => $this->getTrialDaysLeftAttribute(),
            ];
        }
        
        return [
            'status' => 'expired',
            'plan' => 'none',
            'product_limit' => 0,
            'end_date' => null,
            'days_left' => 0,
        ];
    }

    public function getCategoryName($category)
    {
        $categories = [
            'clothes' => '👗 ملابس',
            'electronics' => '📱 إلكترونيات',
            'home' => '🛋️ أدوات منزلية',
            'grocery' => '🛒 بقالة',
            'cars' => '🚗 سيارات',
            'real_estate' => '🏠 عقارات',
            'cleaning' => '🧹 ورشة تنظيف',
        ];
        return $categories[$category] ?? $category;
    }
}
