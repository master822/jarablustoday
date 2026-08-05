@extends('layouts.app')

@section('title', 'المنتجات المستعملة')

@section('content')
<div class="container py-4">
    <h1 class="section-title-rizk text-center mb-4">المنتجات المستعملة</h1>
    
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <div class="product-img-wrapper">
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
                             loading="lazy"
                             style="width:100%; height:100%; object-fit:cover;"
                             onerror="this.src='{{ asset('storage/products/product_1.png') }}'">
                    </div>
                    <div class="product-body">
                        <h6 class="product-title">{{ $product->name }}</h6>
                        <p class="product-description">{{ Str::limit($product->description ?? '', 50) }}</p>
                        
                        <div class="product-footer">
                            <span class="product-price">{{ number_format($product->price ?? 0, 2) }} TL</span>
                            <span class="badge-rizk badge-rizk-gold">مستعمل</span>
                        </div>
                        
                        <div class="seller-info mt-2">
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>
                                {{ $product->user->name ?? 'غير معروف' }}
                            </small>
                            <small class="text-muted mx-2">|</small>
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i>
                                {{ $product->views ?? 0 }}
                            </small>
                        </div>
                        
                        <div class="product-actions mt-3 d-flex gap-2">
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
                <i class="fas fa-recycle fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد منتجات مستعملة</h5>
                <p style="color: var(--text-muted);">كن أول من يضيف منتجاً مستعملاً!</p>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="pagination-simple">
            @if($products->onFirstPage())
                <span class="page-btn disabled">السابق</span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="page-btn">السابق</a>
            @endif
            
            <span class="page-info">صفحة {{ $products->currentPage() }} من {{ $products->lastPage() }}</span>
            
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="page-btn">التالي</a>
            @else
                <span class="page-btn disabled">التالي</span>
            @endif
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
    
    .product-card:hover .product-img-wrapper img {
        transform: scale(1.05);
    }
    
    .product-body {
        padding: 16px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .product-title {
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 6px;
        color: var(--text-primary);
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-description {
        font-size: 0.85rem;
        color: var(--text-muted);
        flex: 1;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid rgba(0,0,0,0.05);
    }
    
    [data-theme="dark"] .product-footer {
        border-top-color: rgba(255,255,255,0.05);
    }
    
    .product-price {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }
    
    .seller-info {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    .product-actions .btn-sm {
        padding: 6px 10px;
        font-size: 0.8rem;
    }
    
    .badge-rizk {
        padding: 4px 12px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.7rem;
    }
    
    .badge-rizk-gold {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: #fff;
    }
    
    .pagination-simple {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
        margin-top: 30px;
        padding: 20px 0;
    }
    
    .pagination-simple .page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: var(--radius-md);
        border: 2px solid var(--primary-color);
        background: var(--bg-card);
        color: var(--text-primary);
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-decoration: none;
        min-width: 140px;
    }
    
    .pagination-simple .page-btn:hover {
        background: var(--primary-color);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .pagination-simple .page-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }
    
    .pagination-simple .page-info {
        color: var(--text-muted);
        font-weight: 500;
        font-size: 0.9rem;
    }
</style>
@endsection
