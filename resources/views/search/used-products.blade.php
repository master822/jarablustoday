@extends('layouts.app')

@section('title', 'بحث المنتجات المستعملة')

@section('content')
<div class="container py-4">
    <h2 class="section-title-rizk mb-4">🔍 بحث المنتجات المستعملة</h2>
    
    <div class="card-rizk p-4 mb-4">
        <form action="{{ route('search.used-products') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label style="color: var(--text-primary);">كلمة البحث</label>
                    <input type="text" name="q" class="form-control form-rizk" placeholder="ابحث عن منتج مستعمل..." value="{{ request('q') }}">
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">السعر من</label>
                    <input type="number" name="min_price" class="form-control form-rizk" placeholder="0" value="{{ request('min_price') }}">
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">السعر إلى</label>
                    <input type="number" name="max_price" class="form-control form-rizk" placeholder="1000" value="{{ request('max_price') }}">
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">الحالة</label>
                    <select name="condition" class="form-select form-rizk">
                        <option value="">الكل</option>
                        <option value="excellent" {{ request('condition') == 'excellent' ? 'selected' : '' }}>ممتاز</option>
                        <option value="very_good" {{ request('condition') == 'very_good' ? 'selected' : '' }}>جيد جداً</option>
                        <option value="good" {{ request('condition') == 'good' ? 'selected' : '' }}>جيد</option>
                        <option value="fair" {{ request('condition') == 'fair' ? 'selected' : '' }}>مقبول</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">&nbsp;</label>
                    <button type="submit" class="btn btn-rizk-primary w-100">
                        <i class="fas fa-search me-2"></i>بحث
                    </button>
                </div>
            </div>
        </form>
        <div class="mt-2">
            <a href="{{ route('search.used-products') }}" class="btn btn-rizk-outline btn-sm">
                <i class="fas fa-undo me-1"></i>مسح البحث
            </a>
        </div>
    </div>
    
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card-rizk p-2 hover-lift">
                    @php
                        $imageUrl = asset('storage/products/product_1.png');
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
                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px;"
                         onerror="this.src='{{ asset('storage/products/product_1.png') }}'">
                    <div class="p-2">
                        <h6 style="color: var(--text-primary); font-size: 0.9rem;">{{ Str::limit($product->name, 20) }}</h6>
                        <div class="d-flex justify-content-between align-items-center">
                            <span style="color: var(--primary-color); font-weight: 700;">
                                {{ number_format($product->price ?? 0, 2) }} TL
                            </span>
                            <span class="badge-rizk badge-rizk-gold" style="font-size: 0.6rem;">مستعمل</span>
                        </div>
                        <p class="small text-muted mt-1">{{ Str::limit($product->description, 40) }}</p>
                        <div class="mt-1 d-flex gap-2">
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="btn btn-rizk-primary btn-sm flex-fill">
                                <i class="fas fa-eye me-1"></i>عرض
                            </a>
                            @auth
                                @if(Auth::id() != $product->user_id)
                                    <a href="{{ route('messages.contact.form', $product->id) }}" 
                                       class="btn btn-rizk-outline btn-sm flex-fill">
                                        <i class="fas fa-envelope me-1"></i>تواصل
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد نتائج</h5>
                <p style="color: var(--text-muted);">حاول تغيير كلمات البحث</p>
            </div>
        @endforelse
    </div>
    
    @if($products->hasPages())
        <div class="pagination-simple mt-4">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
</style>
@endsection
