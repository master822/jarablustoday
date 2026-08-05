@extends('layouts.app')

@section('title', 'بحث المنتجات')

@section('content')
<div class="container py-4">
    <h2 class="section-title-rizk mb-4">🔍 بحث المنتجات</h2>
    
    <!-- نموذج البحث المتقدم -->
    <div class="card-rizk p-4 mb-4">
        <form action="{{ route('search.products') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label style="color: var(--text-primary);">كلمة البحث</label>
                    <input type="text" name="q" class="form-control form-rizk" 
                           placeholder="ابحث عن منتج..." value="{{ request('q') }}">
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">السعر من</label>
                    <input type="number" name="min_price" class="form-control form-rizk" 
                           placeholder="0" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">السعر إلى</label>
                    <input type="number" name="max_price" class="form-control form-rizk" 
                           placeholder="1000" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">الحالة</label>
                    <select name="condition" class="form-select form-rizk">
                        <option value="">الكل</option>
                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>جديد</option>
                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>مستعمل</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">الترتيب</label>
                    <select name="sort" class="form-select form-rizk">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>الأحدث</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر: منخفض</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر: مرتفع</option>
                    </select>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-rizk-primary">
                    <i class="fas fa-search me-2"></i>بحث
                </button>
                <a href="{{ route('search.products') }}" class="btn btn-rizk-outline">
                    <i class="fas fa-undo me-2"></i>إعادة ضبط
                </a>
            </div>
        </form>
    </div>
    
    <!-- نتائج البحث -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <div class="product-img-wrapper">
                        @php
                            $imageUrl = asset('storage/products/product_1.png');
                            if ($product->images) {
                                $images = json_decode($product->images, true);
                                if (is_array($images) && count($images) > 0) {
                                    if (!str_starts_with($images[0], 'http')) {
                                        $imageUrl = asset('storage/' . $images[0]);
                                    } else {
                                        $imageUrl = $images[0];
                                    }
                                }
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" 
                             alt="{{ $product->name }}" 
                             loading="lazy"
                             style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div class="product-body">
                        <h6 class="product-title">{{ $product->name }}</h6>
                        <p class="product-description">{{ Str::limit($product->description ?? '', 50) }}</p>
                        <div class="product-footer">
                            <span class="product-price">{{ number_format($product->price ?? 0, 2) }} TL</span>
                            <span class="badge-rizk badge-rizk-gold">{{ $product->condition }}</span>
                        </div>
                        <div class="product-actions mt-2 d-flex gap-2">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-rizk-primary btn-sm flex-fill">عرض</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد نتائج</h5>
                <p style="color: var(--text-muted);">حاول تغيير كلمات البحث أو الفلاتر</p>
            </div>
        @endforelse
    </div>
    
    @if($products->hasPages())
        <div class="pagination-simple">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    .product-card {
        transition: all 0.3s ease;
        border-radius: 16px;
        overflow: hidden;
        background: var(--bg-card);
        box-shadow: var(--shadow-sm);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }
    .product-img-wrapper {
        position: relative;
        overflow: hidden;
        background: #f1f5f9;
        padding-top: 66.67%;
        height: 0;
    }
    .product-img-wrapper img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; }
    .product-title { font-weight: 700; font-size: 1rem; color: var(--text-primary); }
    .product-description { font-size: 0.85rem; color: var(--text-muted); flex: 1; }
    .product-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 10px; }
    .product-price { font-weight: 700; color: var(--primary-color); font-size: 1.1rem; }
    .badge-rizk { padding: 4px 12px; border-radius: 50px; font-weight: 600; font-size: 0.7rem; }
    .badge-rizk-gold { background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); color: #fff; }
</style>
@endsection
