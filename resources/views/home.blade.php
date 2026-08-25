@extends('layouts.app')

@section('title', 'Rizk - رزق')

@section('content')
<!-- ===== سلايدر الصور - عرض كامل ===== -->
<div id="mainSlider" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    <!-- مؤشرات التنقل -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="2"></button>
        <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="3"></button>
    </div>
    
    <div class="carousel-inner" style="height: 420px;">
        @php
            $sliderProducts = \App\Models\Product::where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
            
            $plans = [
                [
                    'name' => 'الباقة المتوسطة',
                    'price' => '10$',
                    'limit' => '80 منتج',
                    'color' => '#b8860b',
                    'icon' => 'fa-crown'
                ],
                [
                    'name' => 'الباقة الذهبية',
                    'price' => '20$',
                    'limit' => '200 منتج',
                    'color' => '#d4af37',
                    'icon' => 'fa-crown'
                ],
                [
                    'name' => 'فترة تجريبية مجانية',
                    'price' => '0$',
                    'limit' => '25 منتج',
                    'color' => '#22c55e',
                    'icon' => 'fa-gift'
                ],
                [
                    'name' => 'اشترك الآن',
                    'price' => 'خصم 20%',
                    'limit' => 'عرض خاص',
                    'color' => '#ef4444',
                    'icon' => 'fa-fire'
                ]
            ];
        @endphp
        
        <!-- الشريحة 1: أحدث المنتجات -->
        <div class="carousel-item active" style="height: 420px;">
            <div class="slider-content h-100 w-100" style="background: linear-gradient(135deg, #1e293b, #0f172a); display: flex; align-items: center; padding: 0 40px;">
                <div class="container-fluid">
                    <div class="row align-items-center h-100">
                        <div class="col-lg-6 text-white">
                            <h2 class="display-5 fw-bold mb-3">🆕 أحدث المنتجات</h2>
                            <p class="lead mb-4">اكتشف أحدث المنتجات المضافة إلى منصتنا</p>
                            <a href="{{ route('products.index') }}" class="btn btn-rizk-primary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>استكشف الآن
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="row g-2">
                                @foreach($sliderProducts as $product)
                                    <div class="col-6">
                                        <div class="slider-product-card">
                                            @php
                                                $imageUrl = asset('images/product-placeholder.svg');
                                                if ($product->images) {
                                                    $images = json_decode($product->images, true);
                                                    if (is_array($images) && count($images) > 0 && $images[0]) {
                                                        if (file_exists(storage_path('app/public/' . $images[0]))) {
                                                            $imageUrl = asset('storage/' . $images[0]);
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <img src="{{ $imageUrl }}" 
                                                 alt="{{ $product->name }}"
                                                 style="width: 100%; height: 110px; object-fit: cover; border-radius: 8px;">
                                            <div class="slider-product-info">
                                                <small>{{ Str::limit($product->name, 15) }}</small>
                                                <small class="gold-text">{{ number_format($product->price ?? 0, 2) }} TL</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- الشريحة 2: خطط الاشتراك -->
        <div class="carousel-item" style="height: 420px;">
            <div class="slider-content h-100 w-100" style="background: linear-gradient(135deg, #1a1a2e, #16213e); display: flex; align-items: center; padding: 0 40px;">
                <div class="container-fluid">
                    <div class="row align-items-center h-100">
                        <div class="col-lg-6 text-white">
                            <h2 class="display-5 fw-bold mb-3">📋 خطط الاشتراك</h2>
                            <p class="lead mb-4">اختر الباقة المناسبة لك واستمتع بمزايا حصرية</p>
                            <a href="{{ route('subscription.plans') }}" class="btn btn-rizk-primary btn-lg">
                                <i class="fas fa-crown me-2"></i>عرض الخطط
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="row g-2">
                                @foreach($plans as $plan)
                                    <div class="col-6">
                                        <div class="plan-card text-center p-3" style="background: rgba(255,255,255,0.05); border-radius: 12px; border: 1px solid {{ $plan['color'] }};">
                                            <i class="fas {{ $plan['icon'] }} fa-2x" style="color: {{ $plan['color'] }};"></i>
                                            <h6 style="color: #fff; margin: 5px 0;">{{ $plan['name'] }}</h6>
                                            <span style="color: {{ $plan['color'] }}; font-weight: 700; font-size: 1.1rem;">{{ $plan['price'] }}</span>
                                            <br>
                                            <small style="color: #94a3b8;">{{ $plan['limit'] }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- الشريحة 3: عروض خاصة -->
        <div class="carousel-item" style="height: 420px;">
            <div class="slider-content h-100 w-100" style="background: linear-gradient(135deg, #1e293b, #0f172a); display: flex; align-items: center; padding: 0 40px;">
                <div class="container-fluid">
                    <div class="row align-items-center h-100">
                        <div class="col-12 text-center text-white">
                            <div class="mb-3">
                                <span class="badge bg-danger px-4 py-2" style="font-size: 1rem;">
                                    <i class="fas fa-fire me-2"></i>عرض خاص
                                </span>
                            </div>
                            <h2 class="display-4 fw-bold mb-3 gold-gradient-text">🔥 عروض حصرية</h2>
                            <p class="lead mb-4">احصل على تخفيضات تصل إلى 50% على منتجات مختارة</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('discounts') }}" class="btn btn-rizk-primary btn-lg">
                                    <i class="fas fa-tag me-2"></i>استكشف العروض
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-rizk-outline btn-lg">تسوق الآن</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- الشريحة 4: انضم إلينا -->
        <div class="carousel-item" style="height: 420px;">
            <div class="slider-content h-100 w-100" style="background: linear-gradient(135deg, #0f172a, #1e293b); display: flex; align-items: center; padding: 0 40px;">
                <div class="container-fluid">
                    <div class="row align-items-center h-100">
                        <div class="col-12 text-center text-white">
                            <div class="brand-icon mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2rem;">
                                <i class="fas fa-gem"></i>
                            </div>
                            <h2 class="display-5 fw-bold mb-3 gold-gradient-text">انضم إلى Rizk اليوم</h2>
                            <p class="lead mb-4">ابدأ في البيع أو الشراء مع مجتمعنا المتنامي</p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="{{ route('register') }}" class="btn btn-rizk-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-rizk-outline btn-lg">تسجيل الدخول</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- أزرار التنقل -->
    <button class="carousel-control-prev" type="button" data-bs-target="#mainSlider" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" style="background-color: rgba(0,0,0,0.4); border-radius: 50%; padding: 20px; width: 40px; height: 40px; background-size: 60% 60%;"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
        <span class="carousel-control-next-icon" style="background-color: rgba(0,0,0,0.4); border-radius: 50%; padding: 20px; width: 40px; height: 40px; background-size: 60% 60%;"></span>
    </button>
</div>

<!-- باقي المحتوى -->
<div class="container py-4">
    <!-- أحدث المنتجات -->
    <div class="mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="section-title-rizk" style="margin-bottom: 0; color: var(--text-primary);">
                <i class="fas fa-star gold-text me-2"></i>أحدث المنتجات
            </h3>
            <a href="{{ route('products.index') }}" class="btn btn-rizk-outline btn-sm">عرض الكل <i class="fas fa-arrow-left ms-1"></i></a>
        </div>

        @php
            $products = \App\Models\Product::where('status', 'active')
                          ->orderBy('created_at', 'desc')
                          ->take(8)
                          ->get();
        @endphp

        @if($products->count() > 0)
            <div class="row g-3">
                @foreach($products as $product)
                    <div class="col-lg-3 col-md-4 col-6">
                        <div class="product-card h-100">
                            <div class="product-img-wrapper">
                                @php
                                    $imageUrl = asset('images/product-placeholder.svg');
                                    if ($product->images) {
                                        $images = json_decode($product->images, true);
                                        if (is_array($images) && count($images) > 0 && $images[0]) {
                                            if (file_exists(storage_path('app/public/' . $images[0]))) {
                                                $imageUrl = asset('storage/' . $images[0]);
                                            }
                                        }
                                    }
                                @endphp
                                <img src="{{ $imageUrl }}" 
                                     alt="{{ $product->name }}" 
                                     loading="lazy"
                                     style="width: 100%; height: 100%; object-fit: cover;"
                                     onerror="this.onerror=null; this.style.display='none';">
                            </div>
                            <div class="product-body">
                                <h6 class="product-title">{{ Str::limit($product->name, 20) }}</h6>
                                <div class="product-footer">
                                    <span class="product-price">{{ number_format($product->price ?? 0, 2) }} TL</span>
                                    <span class="badge-rizk badge-rizk-gold">{{ $product->condition == 'new' ? 'جديد' : 'مستعمل' }}</span>
                                </div>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-rizk-primary btn-sm w-100 mt-2">
                                    <i class="fas fa-eye me-1"></i>عرض
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x gold-text mb-3"></i>
                <p class="text-muted">لا توجد منتجات حالياً</p>
            </div>
        @endif
    </div>

    <!-- المميزات -->
    <div class="row g-4 mt-5">
        <div class="col-md-3 col-6">
            <div class="card-rizk text-center p-3">
                <i class="fas fa-box fa-2x gold-text mb-2"></i>
                <h6 style="color: var(--text-primary);">منتجات متنوعة</h6>
                <small class="text-muted">آلاف المنتجات بانتظارك</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card-rizk text-center p-3">
                <i class="fas fa-tag fa-2x gold-text mb-2"></i>
                <h6 style="color: var(--text-primary);">أفضل الأسعار</h6>
                <small class="text-muted">عروض وتخفيضات حصرية</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card-rizk text-center p-3">
                <i class="fas fa-store fa-2x gold-text mb-2"></i>
                <h6 style="color: var(--text-primary);">تجار موثوقون</h6>
                <small class="text-muted">متاجر معتمدة وموثوقة</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card-rizk text-center p-3">
                <i class="fas fa-shield-alt fa-2x gold-text mb-2"></i>
                <h6 style="color: var(--text-primary);">دفع آمن</h6>
                <small class="text-muted">تجربة شراء آمنة</small>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== إزالة أي هوامش ===== */
    #mainSlider {
        width: 100%;
        margin: 0;
        padding: 0;
    }
    
    .carousel-inner {
        width: 100%;
    }
    
    .carousel-item {
        width: 100%;
    }
    
    .slider-content {
        width: 100%;
        height: 100%;
    }
    
    /* ===== تنسيق السلايدر ===== */
    .carousel-fade .carousel-item {
        opacity: 0;
        transition: opacity 0.8s ease;
    }
    
    .carousel-fade .carousel-item.active {
        opacity: 1;
    }
    
    .carousel-fade .carousel-item.carousel-item-next,
    .carousel-fade .carousel-item.carousel-item-prev {
        opacity: 0;
    }
    
    .slider-product-card {
        background: rgba(255,255,255,0.05);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .slider-product-card:hover {
        transform: scale(1.05);
    }
    
    .slider-product-info {
        padding: 6px 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .slider-product-info small {
        color: #94a3b8;
        font-size: 0.7rem;
    }
    
    .slider-product-info .gold-text {
        color: var(--primary-color);
        font-weight: 700;
    }
    
    .plan-card {
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
    }
    
    .plan-card:hover {
        transform: translateY(-4px);
        background: rgba(255,255,255,0.1) !important;
    }
    
    .gold-gradient-text {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-light), var(--primary-dark));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        background-size: 60% 60%;
    }
    
    /* ===== تنسيق بطاقات المنتجات ===== */
    .product-card {
        transition: all 0.3s ease;
        border-radius: 12px;
        overflow: hidden;
        background: var(--bg-card);
        box-shadow: var(--shadow-sm);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
    
    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
        padding-top: 75%;
        height: 0;
        width: 100%;
    }
    
    .product-img-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-img-wrapper img {
        transform: scale(1.05);
    }
    
    .product-body {
        padding: 12px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 4px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto;
    }
    
    .product-price {
        font-size: 1rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .badge-rizk {
        padding: 2px 8px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.65rem;
    }
    
    .badge-rizk-gold {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: #fff;
    }
    
    .section-title-rizk {
        position: relative;
        padding-bottom: 10px;
        font-weight: 800;
        font-size: 1.4rem;
    }
    
    .section-title-rizk::after {
        content: '';
        position: absolute;
        bottom: 0;
        right: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 4px;
    }
    
    .gold-text {
        color: var(--primary-color);
    }
    
    /* ===== استجابة للشاشات الصغيرة ===== */
    @media (max-width: 768px) {
        .carousel-inner {
            height: 480px !important;
        }
        .carousel-item {
            height: 480px !important;
        }
        .slider-content {
            padding: 0 20px !important;
        }
        .slider-content .display-5 {
            font-size: 1.3rem !important;
        }
        .slider-content .lead {
            font-size: 0.85rem !important;
        }
        .slider-content .btn-lg {
            font-size: 0.75rem !important;
            padding: 6px 14px !important;
        }
        .slider-product-card img {
            height: 60px !important;
        }
        .slider-product-info small {
            font-size: 0.5rem !important;
        }
        .plan-card h6 {
            font-size: 0.6rem !important;
        }
        .plan-card .fa-2x {
            font-size: 1.2rem !important;
        }
        .plan-card {
            padding: 8px !important;
        }
    }
    
    @media (max-width: 576px) {
        .carousel-inner {
            height: 520px !important;
        }
        .carousel-item {
            height: 520px !important;
        }
    }
</style>

<script>
    // تفعيل التمرير التلقائي عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        var myCarousel = document.getElementById('mainSlider');
        var carousel = new bootstrap.Carousel(myCarousel, {
            interval: 5000,
            ride: 'carousel',
            wrap: true,
            pause: 'hover'
        });
    });
</script>
@endsection
