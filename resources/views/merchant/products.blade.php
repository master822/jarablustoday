@extends('layouts.app')

@section('title', 'منتجاتي')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title-rizk">منتجاتي</h4>
        <a href="{{ route('merchant.products.create') }}" class="btn btn-rizk-primary">+ إضافة منتج</a>
    </div>

    <div class="row g-3">
        @forelse($products as $product)
            <div class="col-md-3">
                <div class="card-rizk hover-lift">
                    <div class="product-img-wrapper" style="height: 150px; overflow: hidden;">
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
                             style="width: 100%; height: 100%; object-fit: cover;"
                             onerror="this.src='{{ asset('storage/products/product_1.png') }}'">
                    </div>
                    <div class="card-body">
                        <h6 style="color: var(--text-primary);">{{ $product->name }}</h6>
                        <p class="small" style="color: var(--text-muted);">{{ Str::limit($product->description, 50) }}</p>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold gold-text">{{ number_format($product->price, 2) }} TL</span>
                            <span class="badge-rizk badge-rizk-gold">{{ $product->condition }}</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('merchant.products.edit', $product->id) }}" class="btn btn-rizk-outline btn-sm w-100">تعديل</a>
                        <form action="{{ route('merchant.products.delete', $product->id) }}" method="POST" class="mt-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-rizk text-center p-5">
                    <i class="fas fa-box-open fa-3x gold-text mb-3"></i>
                    <h5 style="color: var(--text-primary);">لا توجد منتجات</h5>
                    <a href="{{ route('merchant.products.create') }}" class="btn btn-rizk-primary">إضافة منتج</a>
                </div>
            </div>
        @endforelse
    </div>
    {{ $products->links() }}
</div>
@endsection
