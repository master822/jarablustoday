@extends('layouts.app')

@section('title', 'ورشة تنظيف - Rizk')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="gold-gradient-text display-5 fw-bold">
            <i class="fas fa-broom me-2"></i>ورشة تنظيف
        </h1>
        <p class="text-muted">خدمات تنظيف احترافية بجودة عالية</p>
    </div>

    <div class="row g-4">
        @php
            $cleaning_stores = [
                ['name' => 'ورشة النظافة المثالية', 'description' => 'أفضل خدمات التنظيف بجودة عالية', 'city' => 'دمشق', 'rating' => 4.9],
                ['name' => 'ورشة التنظيف الشامل', 'description' => 'تنظيف شامل للمنازل والمكاتب', 'city' => 'حلب', 'rating' => 4.8],
                ['name' => 'ورشة النظافة الذكية', 'description' => 'خدمات تنظيف متطورة بأحدث المعدات', 'city' => 'حمص', 'rating' => 4.7],
                ['name' => 'ورشة التنظيف الفاخر', 'description' => 'تنظيف فاخر بلمسة احترافية', 'city' => 'دمشق', 'rating' => 4.9],
            ];
        @endphp
        @foreach($cleaning_stores as $store)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-lift text-center p-3">
                    <div class="brand-icon mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
                        <i class="fas fa-broom"></i>
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

    <h5 class="mt-5 section-title-rizk">خدمات التنظيف</h5>
    <div class="row g-3">
        @php
            $cleaning_products = [
                ['تنظيف منازل', 'تنظيف شامل للمنازل والشقق', 50],
                ['تنظيف مكاتب', 'تنظيف شامل للمكاتب والشركات', 80],
                ['تنظيف سجاد', 'تنظيف سجاد عميق باستخدام البخار', 30],
                ['تنظيف واجهات', 'تنظيف واجهات المباني الزجاجية', 100],
                ['تنظيف مطابخ', 'تنظيف وتعقيم المطابخ', 40],
                ['تنظيف حمامات', 'تنظيف وتعقيم الحمامات', 35],
                ['تنظيف بعد البناء', 'تنظيف شامل بعد أعمال البناء', 150],
                ['تنظيف أثاث', 'تنظيف وتعقيم الأثاث', 45],
            ];
        @endphp
        @foreach($cleaning_products as $product)
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
