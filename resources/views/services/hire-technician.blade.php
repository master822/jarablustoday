@extends('layouts.app')

@section('title', 'استأجر فني - Rizk')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="gold-gradient-text display-5 fw-bold">
            <i class="fas fa-tools me-2"></i>استأجر فني
        </h1>
        <p class="text-muted">فنيين متخصصين في جميع المجالات مع ضمان الجودة</p>
    </div>

    <div class="row g-4">
        @php
            $technician_stores = [
                ['name' => 'فني متخصص', 'description' => 'فنيين في جميع المجالات', 'city' => 'دمشق', 'rating' => 4.9],
                ['name' => 'فني تكييف', 'description' => 'تركيب وصيانة المكيفات', 'city' => 'حلب', 'rating' => 4.8],
                ['name' => 'فني كهرباء', 'description' => 'أعمال الكهرباء المنزلية', 'city' => 'حمص', 'rating' => 4.7],
                ['name' => 'فني سباكة', 'description' => 'أعمال السباكة والتركيبات', 'city' => 'دمشق', 'rating' => 4.6],
            ];
        @endphp
        @foreach($technician_stores as $store)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-lift text-center p-3">
                    <div class="brand-icon mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, #ef4444, #dc2626);">
                        <i class="fas fa-wrench"></i>
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

    <h5 class="mt-5 section-title-rizk">الفنيين المتاحين</h5>
    <div class="row g-3">
        @php
            $technician_products = [
                ['فني تكييف وتبريد', 'تركيب وصيانة وإصلاح المكيفات', 40],
                ['فني كهرباء منازل', 'تركيب وإصلاح الأعمال الكهربائية', 25],
                ['فني سباكة', 'تركيب وإصلاح أعمال السباكة', 30],
                ['فني إلكترونيات', 'إصلاح الهواتف والحواسيب', 35],
                ['فني نجارة', 'صناعة وتركيب الأثاث الخشبي', 30],
                ['فني حديد', 'أعمال الحدادة واللحام', 28],
                ['فني جبس', 'تركيب الجبس والديكورات', 32],
                ['فني زجاج', 'تركيب الزجاج والمرايا', 22],
            ];
        @endphp
        @foreach($technician_products as $product)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-scale p-2">
                    <h6 style="color: var(--text-primary);">{{ $product[0] }}</h6>
                    <p class="small" style="color: var(--text-muted);">{{ $product[1] }}</p>
                    <div class="d-flex justify-content-between">
                        <span class="gold-text fw-bold">{{ number_format($product[2], 2) }} $/ساعة</span>
                        <button class="btn btn-rizk-primary btn-sm">طلب</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
