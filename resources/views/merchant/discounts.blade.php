@extends('layouts.app')

@section('title', 'التخفيضات')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title-rizk">تخفيضاتي</h4>
        <a href="{{ route('merchant.discounts.create') }}" class="btn btn-rizk-primary">+ إضافة تخفيض</a>
    </div>

    <div class="row g-3">
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
                <div class="card-rizk p-3">
                    <div class="d-flex justify-content-between">
                        <h6 style="color: var(--text-primary);">{{ $discount->name }}</h6>
                        <span class="badge-rizk badge-rizk-gold">{{ $discount->percentage }}%</span>
                    </div>
                    
                    <!-- صورة المنتج -->
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
                            <i class="fas fa-tag me-1"></i>
                            {{ number_format($product->price ?? 0, 2) }} TL
                        </small>
                    </div>
                    
                    <p class="small text-muted mt-2">{{ Str::limit($discount->description, 80) }}</p>
                    
                    <div class="d-flex gap-2 mt-2">
                        <a href="{{ route('discounts.show', $discount->id) }}" 
                           class="btn btn-rizk-primary btn-sm flex-fill">
                            <i class="fas fa-eye me-1"></i>عرض التخفيض
                        </a>
                        
                        @if(Auth::check() && Auth::id() == $discount->merchant_id)
                            <a href="{{ route('merchant.discounts.edit', $discount->id) }}" 
                               class="btn btn-rizk-outline btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('merchant.discounts.delete', $discount->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <!-- زر التواصل مع البائع (للمستخدمين الآخرين) -->
                    @if($product && Auth::check() && Auth::id() != $product->user_id)
                        <div class="mt-2">
                            <a href="{{ route('messages.contact.form', $product->id) }}" 
                               class="btn btn-rizk-outline btn-sm w-100">
                                <i class="fas fa-envelope me-1"></i>تواصل مع البائع
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-rizk text-center p-5">
                    <i class="fas fa-tag fa-3x gold-text mb-3"></i>
                    <h5 style="color: var(--text-primary);">لا توجد تخفيضات</h5>
                    <a href="{{ route('merchant.discounts.create') }}" class="btn btn-rizk-primary">إضافة تخفيض</a>
                </div>
            </div>
        @endforelse
    </div>
    {{ $discounts->links() }}
</div>
@endsection
