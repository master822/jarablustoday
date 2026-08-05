@extends('layouts.app')

@section('title', 'جميع التخفيضات')

@section('content')
<div class="container py-4">
    <h1 class="section-title-rizk text-center mb-4">جميع التخفيضات</h1>
    
    <div class="row g-4">
        @forelse($discounts as $discount)
            @php
                $product = $discount->product;
                $imageUrl = asset('storage/products/product_1.png');
                if ($product && $product->images) {
                    $images = json_decode($product->images, true);
                    if (is_array($images) && count($images) > 0 && $images[0]) {
                        if (file_exists(storage_path('app/public/' . $images[0]))) {
                            $imageUrl = asset('storage/' . $images[0]);
                        }
                    }
                }
            @endphp
            <div class="col-md-4">
                <div class="card-rizk p-3 hover-lift">
                    <div class="d-flex justify-content-between">
                        <h6 style="color: var(--text-primary);">{{ $discount->name }}</h6>
                        <span class="badge-rizk badge-rizk-gold">{{ $discount->percentage }}%</span>
                    </div>
                    
                    <div class="discount-product-img mt-2" style="width: 100%; height: 120px; overflow: hidden; border-radius: 8px; background: #f1f5f9;">
                        <img src="{{ $imageUrl }}" 
                             alt="{{ $product->name ?? 'منتج' }}"
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.src='{{ asset('storage/products/product_1.png') }}'">
                    </div>
                    
                    <div class="mt-2">
                        <small style="color: var(--text-muted);">
                            <i class="fas fa-box me-1"></i>
                            {{ $product->name ?? 'منتج غير موجود' }}
                        </small>
                        <br>
                        <small style="color: var(--text-muted);">
                            <i class="fas fa-store me-1"></i>
                            {{ $discount->merchant->store_name ?? $discount->merchant->name ?? 'غير معروف' }}
                        </small>
                    </div>
                    
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('discounts.show', $discount->id) }}" 
                           class="btn btn-rizk-primary btn-sm flex-fill">
                            <i class="fas fa-eye me-1"></i>عرض التفاصيل
                        </a>
                        @if($product && Auth::check() && Auth::id() != $product->user_id)
                            <a href="{{ route('messages.contact.form', $product->id) }}" 
                               class="btn btn-rizk-outline btn-sm flex-fill">
                                <i class="fas fa-envelope me-1"></i>تواصل
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-tag fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد تخفيضات حالياً</h5>
                <p style="color: var(--text-muted);">ترقبوا التخفيضات القادمة!</p>
            </div>
        @endforelse
    </div>
    
    {{ $discounts->links() }}
</div>
@endsection
