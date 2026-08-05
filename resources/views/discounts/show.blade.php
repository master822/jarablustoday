@extends('layouts.app')

@section('title', $discount->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <h2 style="color: var(--text-primary);">{{ $discount->name }}</h2>
                    <span class="badge-rizk badge-rizk-gold" style="font-size: 1.2rem; padding: 8px 20px;">
                        {{ $discount->percentage }}% تخفيض
                    </span>
                </div>
                
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
                
                <div class="product-image mt-3" style="width: 100%; height: 300px; overflow: hidden; border-radius: 12px; background: #f1f5f9;">
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $product->name ?? 'منتج' }}"
                         style="width: 100%; height: 100%; object-fit: cover;"
                         onerror="this.src='{{ asset('storage/products/product_1.png') }}'">
                </div>
                
                <div class="mt-4">
                    <h6 style="color: var(--text-primary);">تفاصيل المنتج</h6>
                    <div class="row mt-2">
                        <div class="col-6">
                            <small style="color: var(--text-muted);">اسم المنتج</small>
                            <p style="color: var(--text-primary); font-weight: 600;">{{ $product->name ?? 'غير موجود' }}</p>
                        </div>
                        <div class="col-6">
                            <small style="color: var(--text-muted);">السعر الأصلي</small>
                            <p style="color: var(--text-primary); font-weight: 600;">{{ number_format($product->price ?? 0, 2) }} TL</p>
                        </div>
                        <div class="col-6">
                            <small style="color: var(--text-muted);">السعر بعد التخفيض</small>
                            <p style="color: var(--primary-color); font-weight: 700; font-size: 1.2rem;">
                                {{ number_format(($product->price ?? 0) * (1 - ($discount->percentage / 100)), 2) }} TL
                            </p>
                        </div>
                        <div class="col-6">
                            <small style="color: var(--text-muted);">نوع المنتج</small>
                            <p style="color: var(--text-primary); font-weight: 600;">
                                {{ $product->condition == 'new' ? 'جديد' : ($product->condition == 'used' ? 'مستعمل' : $product->condition) }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <h6 style="color: var(--text-primary);">وصف التخفيض</h6>
                    <p style="color: var(--text-secondary);">{{ $discount->description ?? 'لا يوجد وصف' }}</p>
                </div>
                
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-rizk-primary">
                        <i class="fas fa-box me-2"></i>عرض المنتج
                    </a>
                    @if($product && Auth::check() && Auth::id() != $product->user_id)
                        <a href="{{ route('messages.contact.form', $product->id) }}" class="btn btn-rizk-outline">
                            <i class="fas fa-envelope me-2"></i>تواصل مع البائع
                        </a>
                    @endif
                    <a href="{{ route('discounts') }}" class="btn btn-rizk-outline">
                        <i class="fas fa-arrow-right me-2"></i>عودة
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card-rizk p-4">
                <h6 style="color: var(--text-primary);">معلومات سريعة</h6>
                <hr>
                <div class="mb-2">
                    <strong style="color: var(--text-muted);">التخفيض:</strong>
                    <span style="color: var(--primary-color); font-weight: 700;">{{ $discount->percentage }}%</span>
                </div>
                <div class="mb-2">
                    <strong style="color: var(--text-muted);">البائع:</strong>
                    <span>{{ $discount->merchant->store_name ?? $discount->merchant->name ?? 'غير معروف' }}</span>
                </div>
                <div class="mb-2">
                    <strong style="color: var(--text-muted);">تاريخ الإضافة:</strong>
                    <span>{{ $discount->created_at->format('Y-m-d') }}</span>
                </div>
                <div class="mb-2">
                    <strong style="color: var(--text-muted);">الحالة:</strong>
                    <span class="{{ $discount->is_active ? 'text-success' : 'text-danger' }}">
                        {{ $discount->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
