@extends('layouts.app')

@section('title', 'الإحصائيات')

@section('content')
<div class="container py-4">
    <h4 class="section-title-rizk">📊 الإحصائيات</h4>
    
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $totalUsers }}</h2>
                <p style="color: var(--text-muted);">👥 إجمالي المستخدمين</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $totalMerchants }}</h2>
                <p style="color: var(--text-muted);">🏪 التجار</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $totalProducts }}</h2>
                <p style="color: var(--text-muted);">📦 المنتجات</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $totalSubscriptions }}</h2>
                <p style="color: var(--text-muted);">📋 الاشتراكات</p>
            </div>
        </div>
    </div>
    
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card-rizk p-3">
                <h6 style="color: var(--text-primary);">👥 المستخدمين حسب النوع</h6>
                <ul class="list-unstyled">
                    @foreach($usersByType as $type)
                        <li class="d-flex justify-content-between py-1 border-bottom">
                            <span>{{ $type->user_type }}</span>
                            <span class="badge-rizk badge-rizk-gold">{{ $type->total }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-rizk p-3">
                <h6 style="color: var(--text-primary);">📋 الاشتراكات حسب الباقة</h6>
                <ul class="list-unstyled">
                    @foreach($subscriptionsByPlan as $plan)
                        <li class="d-flex justify-content-between py-1 border-bottom">
                            <span>{{ $plan->plan == 'medium' ? 'متوسطة' : 'ذهبية' }}</span>
                            <span class="badge-rizk badge-rizk-gold">{{ $plan->total }}</span>
                        </li>
                    @endforeach
                    <li class="d-flex justify-content-between py-1 border-bottom">
                        <span>الاشتراكات النشطة</span>
                        <span class="badge-rizk badge-rizk-gold">{{ $activeSubscriptions }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <div class="card-rizk p-3">
                <h6 style="color: var(--text-primary);">💰 المدفوعات</h6>
                <ul class="list-unstyled">
                    <li class="d-flex justify-content-between py-1 border-bottom">
                        <span>إجمالي المدفوعات</span>
                        <span class="badge-rizk badge-rizk-gold">${{ number_format($totalPayments, 2) }}</span>
                    </li>
                    <li class="d-flex justify-content-between py-1 border-bottom">
                        <span>طلبات دفع معلقة</span>
                        <span class="badge-rizk badge-rizk-gold">{{ $pendingPayments }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
