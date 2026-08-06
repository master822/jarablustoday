@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    
                    <!-- ===== عرض الصور ===== -->
                    @php
                        $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                        $firstImage = ($images && count($images) > 0) ? $images[0] : null;
                    @endphp

                    @if($images && count($images) > 0)
                        <!-- الصورة الرئيسية -->
                        <div class="main-image-container" id="mainImageContainer">
                            <div class="main-image-wrapper">
                                <img id="mainImage" 
                                     src="{{ asset('storage/' . $firstImage) }}" 
                                     alt="{{ $product->name }}" 
                                     class="main-product-image">
                                <div class="zoom-lens" id="zoomLens"></div>
                            </div>
                        </div>
                        
                        <!-- الصور المصغرة -->
                        <div class="thumbnail-container">
                            @foreach($images as $index => $image)
                                <div class="thumbnail-item {{ $index == 0 ? 'active' : '' }}" 
                                     onclick="changeMainImage('{{ asset('storage/' . $image) }}', this)">
                                    <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}">
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="no-image">
                            <span>لا توجد صور لهذا المنتج</span>
                        </div>
                    @endif
                    
                    <!-- ===== معلومات المنتج ===== -->
                    <div class="product-info">
                        <h2 class="product-title">{{ $product->name }}</h2>
                        
                        <div class="product-details">
                            <div class="detail-item">
                                <span class="detail-label">السعر:</span>
                                <span class="detail-value price">{{ number_format($product->price, 0) }} ل.س</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">الكمية المتاحة:</span>
                                <span class="detail-value quantity">{{ $product->quantity ?? 1 }}</span>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">الوصف:</span>
                            <p class="description-text">{{ $product->description }}</p>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">الحالة:</span>
                            <span class="detail-value condition">{{ $product->condition ?? 'جديد' }}</span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">البائع:</span>
                            <span class="detail-value">{{ $product->user->name ?? 'غير معروف' }}</span>
                        </div>
                        
                        <div class="detail-item">
                            <span class="detail-label">تاريخ الإضافة:</span>
                            <span class="detail-value">{{ $product->created_at ? $product->created_at->format('Y-m-d') : 'غير معروف' }}</span>
                        </div>
                        
                        <div class="action-buttons">
                            @auth
                                @if(Auth::id() != $product->user_id)
                                    <a href="{{ route('messages.contact.form', $product->id) }}" class="btn-contact">
                                        التواصل مع البائع
                                    </a>
                                @else
                                    <span class="owner-label">هذا المنتج خاص بك</span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-contact">
                                    سجل الدخول للتواصل
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== تنسيق الصورة الرئيسية ===== */
.main-image-container {
    position: relative;
    width: 100%;
    margin-bottom: 15px;
}

.main-image-wrapper {
    position: relative;
    width: 100%;
    aspect-ratio: 1 / 1;
    overflow: hidden;
    cursor: crosshair;
    background: #f8f9fa;
    border-radius: 8px;
}

.main-product-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    transition: transform 0.1s ease-out;
}

.main-product-image.zoomed {
    transform-origin: center;
}

/* ===== عدسة التكبير ===== */
.zoom-lens {
    position: absolute;
    top: 0;
    left: 0;
    width: 120px;
    height: 120px;
    background: rgba(212, 175, 55, 0.15);
    border: 2px solid rgba(212, 175, 55, 0.6);
    border-radius: 50%;
    display: none;
    pointer-events: none;
    z-index: 5;
    box-shadow: 0 0 15px rgba(212, 175, 55, 0.3), inset 0 0 8px rgba(212, 175, 55, 0.1);
}

/* ===== الصور المصغرة ===== */
.thumbnail-container {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
    overflow-x: auto;
    padding-bottom: 10px;
}

.thumbnail-item {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    cursor: pointer;
    border: 3px solid transparent;
    border-radius: 6px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.thumbnail-item:hover {
    border-color: #d4af37;
    transform: scale(1.05);
}

.thumbnail-item.active {
    border-color: #d4af37;
    box-shadow: 0 0 12px rgba(212, 175, 55, 0.3);
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ===== معلومات المنتج ===== */
.product-info {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e9ecef;
}

.product-title {
    font-size: 24px;
    margin-bottom: 15px;
    color: #1a1a2e;
}

.product-details {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 15px;
}

.detail-item {
    margin-bottom: 10px;
}

.detail-label {
    font-weight: bold;
    color: #475569;
    display: inline-block;
    min-width: 100px;
}

.detail-value {
    color: #1a1a2e;
}

.detail-value.price {
    color: #d4af37;
    font-size: 20px;
    font-weight: bold;
}

.detail-value.quantity {
    background: #d4af37;
    color: #ffffff;
    padding: 2px 12px;
    border-radius: 20px;
    font-weight: bold;
}

.detail-value.condition {
    background: #17a2b8;
    color: #ffffff;
    padding: 2px 12px;
    border-radius: 20px;
    font-size: 14px;
}

.description-text {
    margin-top: 5px;
    color: #475569;
    line-height: 1.7;
}

/* ===== أزرار ===== */
.action-buttons {
    margin-top: 20px;
}

.btn-contact {
    display: inline-block;
    background: #28a745;
    color: #ffffff;
    padding: 12px 30px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    transition: background 0.3s ease;
}

.btn-contact:hover {
    background: #218838;
    color: #ffffff;
    text-decoration: none;
}

.owner-label {
    color: #6c757d;
    font-style: italic;
}

/* ===== لا توجد صور ===== */
.no-image {
    text-align: center;
    background: #f8f9fa;
    padding: 50px;
    border-radius: 8px;
    color: #94a3b8;
    font-size: 18px;
    margin-bottom: 15px;
}

/* ===== استجابة للشاشات الصغيرة ===== */
@media (max-width: 768px) {
    .zoom-lens {
        display: none !important;
    }
    
    .thumbnail-item {
        width: 60px;
        height: 60px;
    }
    
    .product-details {
        grid-template-columns: 1fr;
    }
    
    .product-title {
        font-size: 20px;
    }
    
    .detail-value.price {
        font-size: 18px;
    }
}

@media (max-width: 576px) {
    .thumbnail-item {
        width: 50px;
        height: 50px;
    }
    
    .btn-contact {
        display: block;
        text-align: center;
    }
}
</style>

<script>
// ===== Zoom Configuration =====
const ZOOM_LEVEL = 2;           // Zoom level (2x = 200%)
const LENS_SIZE = 120;          // Lens size in pixels

// ===== DOM Elements =====
const mainImageWrapper = document.querySelector('.main-image-wrapper');
const mainImage = document.getElementById('mainImage');
const zoomLens = document.getElementById('zoomLens');

// ===== State Variables =====
let isZoomActive = false;
let wrapperRect = null;

// ===== Update wrapper dimensions =====
function updateWrapperRect() {
    wrapperRect = mainImageWrapper.getBoundingClientRect();
}

// ===== Initialize on image load =====
mainImage.addEventListener('load', function() {
    updateWrapperRect();
});

// ===== Change Main Image =====
function changeMainImage(src, element) {
    mainImage.src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-item').forEach(item => {
        item.classList.remove('active');
    });
    element.classList.add('active');
    
    // Reset zoom
    hideZoom();
    
    // Update dimensions when new image loads
    mainImage.onload = function() {
        updateWrapperRect();
    };
}

// ===== Show Zoom =====
function showZoom() {
    if (window.innerWidth <= 768) return;
    
    isZoomActive = true;
    zoomLens.style.display = 'block';
    mainImage.classList.add('zoomed');
}

// ===== Hide Zoom =====
function hideZoom() {
    isZoomActive = false;
    zoomLens.style.display = 'none';
    mainImage.classList.remove('zoomed');
    mainImage.style.transform = 'scale(1)';
    mainImage.style.transformOrigin = 'center';
}

// ===== Handle Mouse Enter =====
mainImageWrapper.addEventListener('mouseenter', showZoom);

// ===== Handle Mouse Leave =====
mainImageWrapper.addEventListener('mouseleave', hideZoom);

// ===== Handle Mouse Move for Zoom =====
mainImageWrapper.addEventListener('mousemove', function(e) {
    if (!isZoomActive || window.innerWidth <= 768) return;
    
    updateWrapperRect();
    
    // Calculate cursor position relative to wrapper
    const x = e.clientX - wrapperRect.left;
    const y = e.clientY - wrapperRect.top;
    
    // Constrain lens position within wrapper bounds
    const constrainedX = Math.max(LENS_SIZE / 2, Math.min(x, wrapperRect.width - LENS_SIZE / 2));
    const constrainedY = Math.max(LENS_SIZE / 2, Math.min(y, wrapperRect.height - LENS_SIZE / 2));
    
    // Position the lens circle
    zoomLens.style.left = (constrainedX - LENS_SIZE / 2) + 'px';
    zoomLens.style.top = (constrainedY - LENS_SIZE / 2) + 'px';
    
    // Calculate zoom transformation
    // The image zooms in towards the lens position
    const centerX = (constrainedX / wrapperRect.width) * 100;
    const centerY = (constrainedY / wrapperRect.height) * 100;
    
    // Apply zoom with transform origin at lens position
    mainImage.style.transformOrigin = centerX + '% ' + centerY + '%';
    mainImage.style.transform = 'scale(' + ZOOM_LEVEL + ')';
});

// ===== Handle Window Resize =====
window.addEventListener('resize', function() {
    updateWrapperRect();
    if (window.innerWidth <= 768) {
        hideZoom();
    }
});

// ===== Initialize on Page Load =====
document.addEventListener('DOMContentLoaded', function() {
    updateWrapperRect();
});
</script>
@endsection