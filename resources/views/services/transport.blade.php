@extends('layouts.app')

@section('title', 'سيارة نقل - Rizk')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="gold-gradient-text display-5 fw-bold">
            <i class="fas fa-truck me-2"></i>سيارة نقل
        </h1>
        <p class="text-muted">خدمات نقل سريعة وآمنة</p>
    </div>

    <div class="row g-4">
        @php
            $transport_stores = [
                ['name' => 'نقل سريع', 'description' => 'خدمة نقل سريعة لجميع أنحاء المدينة', 'city' => 'دمشق', 'rating' => 4.8],
                ['name' => 'نقل آمن', 'description' => 'نقل آمن مع تأمين شامل', 'city' => 'حلب', 'rating' => 4.7],
                ['name' => 'نقل فاخر', 'description' => 'سيارات حديثة لنقل الأثاث والعفش', 'city' => 'حمص', 'rating' => 4.6],
                ['name' => 'نقل البضائع', 'description' => 'نقل بضائع تجارية وصناعية', 'city' => 'دمشق', 'rating' => 4.5],
            ];
        @endphp
        @foreach($transport_stores as $store)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-lift text-center p-3">
                    <div class="brand-icon mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, #f59e0b, #d97706);">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h6 style="color: var(--text-primary); font-weight: 700;">{{ $store['name'] }}</h6>
                    <p class="small" style="color: var(--text-muted);">{{ $store['description'] }}</p>
                    <div class="d-flex justify-content-center gap-2 small">
                        <span><i class="fas fa-map-marker-alt gold-text"></i> {{ $store['city'] }}</span>
                        <span><i class="fas fa-star gold-text"></i> {{ $store['rating'] }}</span>
                    </div>
                    <a href="#" class="btn btn-rizk-outline btn-sm mt-2">طلب خدمة</a>
                </div>
            </div>
        @endforeach
    </div>

    <h5 class="mt-5 section-title-rizk">خدمات النقل</h5>
    <div class="row g-3">
        @php
            $transport_products = [
                ['نقل أثاث منزلي', 'مع التغليف والتركيب', 80],
                ['نقل بضائع تجارية', 'داخل المدينة وبين المدن', 150],
                ['نقل عفش كامل', 'مع التغليف والتركيب', 200],
                ['نقل أجهزة إلكترونية', 'تغليف خاص وضمان السلامة', 60],
                ['نقل مستلزمات مطعم', 'فريق متخصص', 250],
                ['نقل مكاتب', 'نقل أثاث المكاتب', 120],
                ['نقل معدات ثقيلة', 'معدات خاصة للنقل الثقيل', 350],
                ['نقل سريع للطرود', 'توصيل سريع خلال ساعات', 30],
            ];
        @endphp
        @foreach($transport_products as $product)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-scale p-2">
                    <h6 style="color: var(--text-primary);">{{ $product[0] }}</h6>
                    <p class="small" style="color: var(--text-muted);">{{ $product[1] }}</p>
                    <div class="d-flex justify-content-between">
                        <span class="gold-text fw-bold">{{ number_format($product[2], 2) }} $</span>
                        <button class="btn btn-rizk-primary btn-sm">طلب</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
