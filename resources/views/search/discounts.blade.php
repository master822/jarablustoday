@extends('layouts.app')

@section('title', 'بحث التخفيضات')

@section('content')
<div class="container py-4">
    <h2 class="section-title-rizk mb-4">🔍 بحث التخفيضات</h2>
    
    <div class="card-rizk p-4 mb-4">
        <form action="{{ route('search.discounts') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label style="color: var(--text-primary);">كلمة البحث</label>
                    <input type="text" name="q" class="form-control form-rizk" placeholder="ابحث عن تخفيض..." value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <label style="color: var(--text-primary);">نسبة التخفيض من</label>
                    <input type="number" name="min_discount" class="form-control form-rizk" placeholder="0" value="{{ request('min_discount') }}">
                </div>
                <div class="col-md-3">
                    <label style="color: var(--text-primary);">نسبة التخفيض إلى</label>
                    <input type="number" name="max_discount" class="form-control form-rizk" placeholder="100" value="{{ request('max_discount') }}">
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
            <a href="{{ route('search.discounts') }}" class="btn btn-rizk-outline btn-sm">
                <i class="fas fa-undo me-1"></i>مسح البحث
            </a>
        </div>
    </div>
    
    <div class="row g-4">
        @forelse($discounts as $discount)
            @php
                $product = $discount->product;
                $imageUrl = asset('images/product-placeholder.svg');
                if ($product && $product->images) {
                    $images = json_decode($product->images, true);
                    if (is_array($images) && count($images) > 0 && $images[0]) {
                        if (file_exists(storage_path('app/public/' . $images[0]))) {
                            $imageUrl = asset('storage/' . $images[0]);
                        }
                    }
                }
            @endphp
            <div class="col-md-4 col-lg-3">
                <div class="card-rizk p-3 hover-lift">
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $product->name ?? 'منتج' }}"
                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;"
                         onerror="this.onerror=null; this.style.display='none';">
                    
                    <div class="d-flex justify-content-between align-items-start">
                        <h6 style="color: var(--text-primary);">{{ $discount->name }}</h6>
                        <span class="badge-rizk badge-rizk-gold">{{ $discount->percentage }}%</span>
                    </div>
                    <p class="small text-muted">{{ Str::limit($discount->description, 50) }}</p>
                    @if($product)
                        <p class="small text-muted">
                            <i class="fas fa-box me-1"></i>{{ $product->name }}
                        </p>
                        <p style="color: var(--primary-color); font-weight: 700;">
                            {{ number_format($product->price ?? 0, 2) }} TL
                        </p>
                    @endif
                    <div class="mt-2 d-flex gap-2">
                        @if($product)
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
                        @endif
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
    
    @if($discounts->hasPages())
        <div class="pagination-simple mt-4">
            {{ $discounts->appends(request()->query())->links('pagination::bootstrap-5') }}
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
