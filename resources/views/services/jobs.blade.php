@extends('layouts.app')

@section('title', 'فرص عمل - Rizk')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="gold-gradient-text display-5 fw-bold">
            <i class="fas fa-briefcase me-2"></i>فرص عمل
        </h1>
        <p class="text-muted">أفضل فرص العمل في مختلف المجالات</p>
    </div>

    <div class="row g-4">
        @php
            $job_stores = [
                ['name' => 'وظيفتك', 'description' => 'أفضل فرص العمل في مختلف المجالات', 'city' => 'دمشق', 'rating' => 4.9],
                ['name' => 'شركة تقنية', 'description' => 'فرص في مجال التقنية والبرمجة', 'city' => 'حلب', 'rating' => 4.7],
                ['name' => 'شركة تجارية', 'description' => 'فرص في مجال التجارة والتسويق', 'city' => 'حمص', 'rating' => 4.5],
                ['name' => 'شركة خدمات', 'description' => 'فرص في مجال الخدمات والإدارة', 'city' => 'دمشق', 'rating' => 4.6],
            ];
        @endphp
        @foreach($job_stores as $store)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-lift text-center p-3">
                    <div class="brand-icon mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, #06b6d4, #0891b2);">
                        <i class="fas fa-building"></i>
                    </div>
                    <h6 style="color: var(--text-primary); font-weight: 700;">{{ $store['name'] }}</h6>
                    <p class="small" style="color: var(--text-muted);">{{ $store['description'] }}</p>
                    <div class="d-flex justify-content-center gap-2 small">
                        <span><i class="fas fa-map-marker-alt gold-text"></i> {{ $store['city'] }}</span>
                        <span><i class="fas fa-star gold-text"></i> {{ $store['rating'] }}</span>
                    </div>
                    <a href="#" class="btn btn-rizk-outline btn-sm mt-2">تقدم الآن</a>
                </div>
            </div>
        @endforeach
    </div>

    <h5 class="mt-5 section-title-rizk">الوظائف الشاغرة</h5>
    <div class="row g-3">
        @php
            $job_products = [
                ['مطلوب مصمم جرافيك', 'دوام جزئي، خبرة في Photoshop و Illustrator', 0],
                ['مطلوب مساعد إداري', 'دوام كامل، خبرة في العمل الإداري', 0],
                ['مطلوب مطور ويب', 'دوام كامل، خبرة في Laravel و React', 0],
                ['مطلوب محاسب', 'دوام كامل، خبرة في المحاسبة المالية', 0],
                ['مطلوب مسوق رقمي', 'دوام جزئي، خبرة في التسويق الإلكتروني', 0],
                ['مطلوب مهندس معماري', 'دوام كامل، خبرة في التصميم المعماري', 0],
                ['مطلوب مدير مشروع', 'دوام كامل، خبرة في إدارة المشاريع', 0],
                ['مطلوب سائق', 'دوام كامل، رخصة قيادة سارية', 0],
            ];
        @endphp
        @foreach($job_products as $product)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-scale p-2">
                    <h6 style="color: var(--text-primary);">{{ $product[0] }}</h6>
                    <p class="small" style="color: var(--text-muted);">{{ $product[1] }}</p>
                    <div class="d-flex justify-content-between">
                        <span class="badge-rizk badge-rizk-gold">تقدم الآن</span>
                        <button class="btn btn-rizk-primary btn-sm">تقدم</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
