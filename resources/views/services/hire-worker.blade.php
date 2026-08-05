@extends('layouts.app')

@section('title', 'استأجر عامل - Rizk')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="gold-gradient-text display-5 fw-bold">
            <i class="fas fa-user-tie me-2"></i>استأجر عامل
        </h1>
        <p class="text-muted">أفضل العمال المهرة بأسعار تنافسية</p>
    </div>

    <div class="row g-4">
        @php
            $worker_stores = [
                ['name' => 'عامل مثالي', 'description' => 'أفضل العمال المهرة في جميع المجالات', 'city' => 'دمشق', 'rating' => 4.9],
                ['name' => 'عمال البناء', 'description' => 'عمال بناء ماهرين', 'city' => 'حلب', 'rating' => 4.7],
                ['name' => 'عمال النظافة', 'description' => 'عمال نظافة محترفين', 'city' => 'حمص', 'rating' => 4.6],
                ['name' => 'عمال الحدائق', 'description' => 'عمال متخصصين في الزراعة', 'city' => 'دمشق', 'rating' => 4.5],
            ];
        @endphp
        @foreach($worker_stores as $store)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-lift text-center p-3">
                    <div class="brand-icon mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, #64748b, #475569);">
                        <i class="fas fa-hard-hat"></i>
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

    <h5 class="mt-5 section-title-rizk">العمال المتاحون</h5>
    <div class="row g-3">
        @php
            $worker_products = [
                ['عامل بناء ماهر', 'خبرة 10 سنوات، أعمال دقيقة', 30],
                ['عامل نظافة منازل', 'خبرة في التنظيف العميق', 20],
                ['عامل حدائق', 'متخصص في الزراعة والتشجير', 25],
                ['عامل صيانة', 'سباكة وكهرباء ونجارة', 30],
                ['عامل تحميل وتفريغ', 'قوي ومرن للعمل الفوري', 15],
                ['عامل دهان', 'خبرة في الدهانات الداخلية والخارجية', 28],
                ['عامل بلاط', 'تركيب البلاط والسيراميك', 35],
                ['عامل نجار', 'أعمال الخشب والأثاث', 30],
            ];
        @endphp
        @foreach($worker_products as $product)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-scale p-2">
                    <h6 style="color: var(--text-primary);">{{ $product[0] }}</h6>
                    <p class="small" style="color: var(--text-muted);">{{ $product[1] }}</p>
                    <div class="d-flex justify-content-between">
                        <span class="gold-text fw-bold">{{ number_format($product[2], 2) }} $/يوم</span>
                        <button class="btn btn-rizk-primary btn-sm">طلب</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
