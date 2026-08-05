@extends('layouts.app')

@section('title', 'خطط الاشتراك - باقاتي')

@section('content')
<div class="container py-5">
    <h1 class="section-title-rizk text-center mb-4">📋 باقاتي</h1>
    
    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif
    
    <!-- عرض الباقة الحالية -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card-rizk p-4">
                <h5 style="color: var(--text-primary);">📊 حالة اشتراكك الحالية</h5>
                <hr>
                
                @php
                    $user = Auth::user();
                    $subscription = \App\Models\Subscription::where('user_id', $user->id)
                                                           ->where('status', 'active')
                                                           ->first();
                    
                    $isOnTrial = false;
                    $trialDaysLeft = 0;
                    $trialEndDate = null;
                    
                    if ($user->created_at) {
                        $trialEnd = $user->created_at->addMonths(4);
                        $trialDaysLeft = (int) max(0, ceil(now()->diffInDays($trialEnd, false)));
                        $isOnTrial = $trialDaysLeft > 0;
                        $trialEndDate = $trialEnd;
                    }
                @endphp
                
                @if($subscription && $subscription->isActive())
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>✅ اشتراكك نشط</strong>
                        <br>
                        <span class="badge bg-primary">{{ $subscription->plan == 'medium' ? 'الباقة المتوسطة' : 'الباقة الذهبية' }}</span>
                        <br>
                        <small>عدد المنتجات المسموح بها: <strong>{{ $subscription->product_limit }}</strong></small>
                        <br>
                        <small>تاريخ البدء: {{ $subscription->start_date->format('Y-m-d') }}</small>
                        <br>
                        <small>تاريخ الانتهاء: {{ $subscription->end_date->format('Y-m-d') }}</small>
                        <br>
                        <small>الأيام المتبقية: <strong>{{ (int) max(0, ceil(now()->diffInDays($subscription->end_date, false))) }} يوم</strong></small>
                    </div>
                    
                @elseif($isOnTrial)
                    <div class="alert alert-info">
                        <i class="fas fa-gift me-2"></i>
                        <strong>🎁 أنت في الفترة المجانية</strong>
                        <br>
                        <span class="badge bg-success">مجاني</span>
                        <br>
                        <small>عدد المنتجات المسموح بها: <strong>25 منتج</strong></small>
                        <br>
                        <small>تاريخ الانتهاء: {{ $trialEndDate->format('Y-m-d') }}</small>
                        <br>
                        <small>الأيام المتبقية: <strong>{{ $trialDaysLeft }} يوم</strong></small>
                        @if($trialDaysLeft < 30)
                            <div class="alert alert-warning mt-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>تنبيه!</strong> الفترة المجانية على وشك الانتهاء. اشترك الآن لتستمر في بيع منتجاتك.
                            </div>
                        @endif
                    </div>
                    
                @else
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>⚠️ لا يوجد اشتراك نشط</strong>
                        <br>
                        <span class="badge bg-danger">منتهي</span>
                        <br>
                        <small>انتهت الفترة المجانية أو الاشتراك.</small>
                        <br>
                        <small>يرجى الاشتراك في إحدى الباقات المدفوعة لمواصلة البيع.</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- خطط الاشتراك -->
    <h4 class="section-title-rizk text-center mb-4">📦 خطط الاشتراك المتاحة</h4>
    
    <div class="row g-4 justify-content-center">
        @php
            $plans = [
                [
                    'name' => 'الباقة المتوسطة',
                    'key' => 'medium',
                    'price' => 10,
                    'product_limit' => 80,
                    'color' => 'bronze',
                    'icon' => 'fa-crown',
                    'features' => [
                        '80 منتج',
                        'دعم فني',
                        'إحصائيات متقدمة',
                    ]
                ],
                [
                    'name' => 'الباقة الذهبية',
                    'key' => 'gold',
                    'price' => 20,
                    'product_limit' => 200,
                    'color' => 'gold',
                    'icon' => 'fa-crown',
                    'features' => [
                        '200 منتج',
                        'دعم فني أولوية',
                        'إحصائيات متقدمة',
                        'تخفيضات حصرية',
                    ]
                ],
            ];
        @endphp
        
        @foreach($plans as $plan)
            <div class="col-md-6 col-lg-5">
                <div class="card-rizk p-4 text-center {{ $plan['color'] == 'gold' ? 'border-warning shadow-lg' : '' }}">
                    <div class="mb-3">
                        <i class="fas {{ $plan['icon'] }} fa-3x" style="color: {{ $plan['color'] == 'gold' ? '#d4af37' : '#b8860b' }};"></i>
                    </div>
                    <h4 style="color: var(--text-primary);">{{ $plan['name'] }}</h4>
                    <div class="my-3">
                        <span style="font-size: 2.5rem; font-weight: 800; color: var(--primary-color);">
                            ${{ $plan['price'] }}
                        </span>
                        <span style="color: var(--text-muted);">/ شهرياً</span>
                    </div>
                    <ul class="list-unstyled text-start">
                        @foreach($plan['features'] as $feature)
                            <li class="py-1">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                {{ $feature }}
                            </li>
                        @endforeach
                    </ul>
                    
                    @if($subscription && $subscription->isActive() && $subscription->plan == $plan['key'])
                        <button class="btn btn-success w-100 mt-3" disabled>
                            <i class="fas fa-check me-2"></i>اشتراك نشط
                        </button>
                    @else
                        <a href="{{ route('subscription.checkout', $plan['key']) }}" 
                           class="btn btn-rizk-primary w-100 mt-3">
                            اشترك الآن
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="text-center mt-4">
        <small style="color: var(--text-muted);">
            * جميع المبالغ بالدولار الأمريكي
            <br>
            * يمكنك إلغاء الاشتراك في أي وقت
        </small>
    </div>
</div>
@endsection
