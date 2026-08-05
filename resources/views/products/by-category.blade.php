@extends('layouts.app')

@section('title', $category->name . ' - Rizk')

@section('content')
<div class="container py-4">
    <h1 class="section-title-rizk text-center mb-4">
        <i class="fas fa-tag me-2"></i>{{ $category->name }}
    </h1>
    
    <div class="row g-4 product-grid">
        @forelse($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="product-card">
                    <div class="product-img-wrapper">
                        @php
                            $imageUrl = 'https://via.placeholder.com/300x200/d4af37/ffffff?text=' . urlencode($product->name);
                            if ($product->images) {
                                $images = json_decode($product->images, true);
                                if (is_array($images) && count($images) > 0 && $images[0]) {
                                    $imagePath = storage_path('app/public/' . $images[0]);
                                    if (file_exists($imagePath)) {
                                        $imageUrl = asset('storage/' . $images[0]);
                                    }
                                }
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" 
                             alt="{{ $product->name }}" 
                             loading="lazy"
                             onerror="this.src='https://via.placeholder.com/300x200/d4af37/ffffff?text={{ urlencode($product->name) }}'">
                    </div>
                    <div class="product-body">
                        <h6 class="product-title">{{ $product->name }}</h6>
                        <p class="product-description">{{ Str::limit($product->description ?? '', 60) }}</p>
                        <div class="product-footer">
                            <span class="product-price">{{ number_format($product->price ?? 0, 2) }} TL</span>
                            <div class="product-meta">
                                <span>{{ $product->user->name ?? 'غير معروف' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد منتجات في هذا التصنيف</h5>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="pagination-simple">
            @if($products->onFirstPage())
                <span class="page-btn disabled"><i class="fas fa-arrow-right"></i> السابق</span>
            @else
                <a href="{{ $products->previousPageUrl() }}" class="page-btn"><i class="fas fa-arrow-right"></i> السابق</a>
            @endif
            
            <span class="page-info">صفحة {{ $products->currentPage() }} من {{ $products->lastPage() }}</span>
            
            @if($products->hasMorePages())
                <a href="{{ $products->nextPageUrl() }}" class="page-btn">التالي <i class="fas fa-arrow-left"></i></a>
            @else
                <span class="page-btn disabled">التالي <i class="fas fa-arrow-left"></i></span>
            @endif
        </div>
    @endif
</div>

<style>
    .product-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
    
    [data-theme="dark"] .product-img-wrapper {
        background: #1e293b;
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
        margin-top: auto;
        flex-wrap: wrap;
        gap: 4px;
    }
    
    [data-theme="dark"] .product-footer {
        border-top-color: rgba(255,255,255,0.05);
    }
    
    .product-price {
        font-weight: 700;
        color: var(--primary-color);
        font-size: 1.1rem;
    }
    
    .product-meta {
        font-size: 0.7rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 4px;
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
    
    [data-theme="dark"] .pagination-simple .page-btn {
        background: #1e293b;
        border-color: #f0d060;
        color: #f1f5f9;
    }
    
    [data-theme="dark"] .pagination-simple .page-btn:hover {
        background: #f0d060;
        color: #0f172a;
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
    
    .product-grid .product-card {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }
    
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @media (max-width: 576px) {
        .pagination-simple .page-btn {
            padding: 10px 18px;
            min-width: 100px;
            font-size: 0.85rem;
        }
    }
</style>
@endsection
