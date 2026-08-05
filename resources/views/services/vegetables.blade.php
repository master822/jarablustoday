@extends('layouts.app')

@section('title', 'خضار مقطعة - Rizk')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="gold-gradient-text display-5 fw-bold">
            <i class="fas fa-leaf me-2"></i>خضار مقطعة
        </h1>
        <p class="text-muted">خضار طازجة مقطعة وجاهزة للطبخ</p>
    </div>

    <!-- متاجر الخضار -->
    <div class="row g-4">
        @php
            $vegetable_stores = [
                ['name' => 'خضارك الطازجة', 'description' => 'أفضل الخضار المقطعة بجودة عالية', 'city' => 'دمشق', 'rating' => 4.9],
                ['name' => 'سوق الخضار', 'description' => 'خضار طازجة من المزرعة إلى منزلك', 'city' => 'حلب', 'rating' => 4.7],
                ['name' => 'خضار اليوم', 'description' => 'خضار طازجة مقطعة يومياً', 'city' => 'حمص', 'rating' => 4.6],
                ['name' => 'خضار المزرعة', 'description' => 'منتجات عضوية طازجة', 'city' => 'دمشق', 'rating' => 4.8],
                ['name' => 'خضار الشام', 'description' => 'تشكيلة متنوعة من الخضار الطازجة', 'city' => 'دمشق', 'rating' => 4.5],
            ];
        @endphp
        @foreach($vegetable_stores as $store)
            <div class="col-md-4 col-6">
                <div class="card-rizk hover-lift text-center p-3">
                    <div class="brand-icon mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem; background: linear-gradient(135deg, #22c55e, #16a34a);">
                        <i class="fas fa-seedling"></i>
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

    <!-- منتجات الخضار -->
    <h5 class="mt-5 section-title-rizk">منتجاتنا</h5>
    <div class="row g-3">
        @php
            $vegetable_products = [
                ['طبق خضار مشكل مقطع', 'جزر، كوسا، بطاطا، باذنجان، فلفل', 8],
                ['علبة خضار مشكلة', 'تشكيلة متنوعة من الخضار الطازجة', 12],
                ['خضار للسلطة', 'خيار، طماطم، فلفل، بصل، خس', 5],
                ['باقة خضار أسبوعية', 'خضار تكفي لعائلة لمدة أسبوع', 15],
                ['خضار للشواء', 'فلفل، باذنجان، كوسا، بصل', 6],
                ['خضار للحساء', 'جزر، بصل، كرفس، بطاطا', 7],
                ['خضار عضوية', 'تشكيلة من الخضار العضوية', 10],
                ['فواكه مقطعة', 'تشكيلة من الفواكه الطازجة المقطعة', 9],
            ];
        @endphp
        @foreach($vegetable_products as $product)
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
