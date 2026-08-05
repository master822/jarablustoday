@extends('layouts.app')

@section('title', 'طبخ منزل - Rizk')

@section('content')
<div class="container py-4">
    <div class="text-center mb-4">
        <h1 class="gold-gradient-text display-5 fw-bold">
            <i class="fas fa-utensils me-2"></i>طبخ منزل
        </h1>
        <p class="text-muted">أشهى الأطباق المنزلية بلمسة سورية أصيلة</p>
    </div>

    <!-- مطابخ سورية -->
    <div class="row g-4">
        @php
            $cooking_stores = [
                ['name' => 'مطبخ أميرة', 'description' => 'أشهى المأكولات السورية بلمسة منزلية', 'city' => 'دمشق', 'rating' => 5],
                ['name' => 'مطبخ نورا', 'description' => 'أكلات سورية تقليدية بجودة عالية', 'city' => 'حلب', 'rating' => 4.8],
                ['name' => 'مطبخ سلمى', 'description' => 'منوعات من المطبخ السوري', 'city' => 'حمص', 'rating' => 4.7],
                ['name' => 'مطبخ ليلى', 'description' => 'أطباق سورية فاخرة للمناسبات', 'city' => 'دمشق', 'rating' => 4.9],
                ['name' => 'مطبخ هدى', 'description' => 'أكلات شامية أصيلة', 'city' => 'دمشق', 'rating' => 4.6],
                ['name' => 'مطبخ ريم', 'description' => 'مأكولات سورية متنوعة بأسعار مناسبة', 'city' => 'حلب', 'rating' => 4.5],
            ];
        @endphp
        @foreach($cooking_stores as $store)
            <div class="col-md-4 col-6">
                <div class="card-rizk hover-lift text-center p-3">
                    <div class="brand-icon mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                        <i class="fas fa-utensil-spoon"></i>
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

    <!-- منتجات الطبخ -->
    <h5 class="mt-5 section-title-rizk">منتجاتنا</h5>
    <div class="row g-3">
        @php
            $cooking_products = [
                ['وجبة عشاء عائلية', 'وجبة متكاملة تشمل أرز، لحم، سلطة، وحلوى، تكفي 5 أشخاص', 35],
                ['مأدبة عشاء فاخرة', 'مشاوي مشكلة، مقبلات، سلطات، وحلويات شرقية', 60],
                ['وجبة غداء صحية', 'دجاج مشوي، أرز بني، خضار سوتيه، سلطة', 25],
                ['حلى شرقي', 'تشكيلة من الكنافة والبقلاوة والمعمول', 20],
                ['وجبة مناسبات', 'أطباق رئيسية، مقبلات، مشروبات، وحلويات', 100],
                ['مشاوي مشكلة', 'تشكيلة من اللحوم المشوية مع الأرز والسلطة', 45],
                ['فتوش', 'سلطة فتوش سورية مع خبز محمص', 10],
                ['تبولة', 'تبولة سورية طازجة', 8],
            ];
        @endphp
        @foreach($cooking_products as $product)
            <div class="col-md-3 col-6">
                <div class="card-rizk hover-scale p-2">
                    <h6 style="color: var(--text-primary);">{{ $product[0] }}</h6>
                    <p class="small" style="color: var(--text-muted);">{{ Str::limit($product[1], 30) }}</p>
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
