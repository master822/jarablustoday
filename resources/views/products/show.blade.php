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
                            <div class="zoom-result" id="zoomResult">
                                <img id="zoomImage" src="{{ asset('storage/' . $firstImage) }}" alt="تكبير">
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
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.main-image-wrapper {
    position: relative;
    flex: 1;
    aspect-ratio: 1;
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
}

/* ===== عدسة التكبير ===== */
.zoom-lens {
    position: absolute;
    top: 0;
    left: 0;
    width: 150px;
    height: 150px;
    background: rgba(212, 175, 55, 0.15);
    border: 2px solid rgba(212, 175, 55, 0.5);
    border-radius: 4px;
    display: none;
    pointer-events: none;
    z-index: 5;
    box-shadow: inset 0 0 8px rgba(212, 175, 55, 0.2);
}

/* ===== نافذة التكبير ===== */
.zoom-result {
    display: none;
    position: absolute;
    top: 0;
    left: 110%;
    width: 100%;
    aspect-ratio: 1;
    border: 2px solid #d4af37;
    border-radius: 8px;
    background: #ffffff;
    overflow: hidden;
    z-index: 10;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.zoom-result img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
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
@media (max-width: 992px) {
    .main-image-container {
        flex-direction: column;
    }
    
    .zoom-result {
        display: none !important;
    }
    
    .zoom-lens {
        display: none !important;
    }
}

@media (max-width: 768px) {
    .zoom-result {
        display: none !important;
    }
    
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
// ===== Image Zoom Configuration =====
const ZOOM_LEVEL = 2.5; // Zoom level (2.5x = 250%)
const LENS_SIZE = 150; // Lens size in pixels

// ===== DOM Elements =====
const mainContainer = document.getElementById('mainImageContainer');
const mainImageWrapper = document.querySelector('.main-image-wrapper');
const mainImage = document.getElementById('mainImage');
const zoomResult = document.getElementById('zoomResult');
const zoomImage = document.getElementById('zoomImage');
const zoomLens = document.getElementById('zoomLens');

// ===== Image State =====
let isZoomActive = false;
let imageDimensions = {
    width: 0,
    height: 0,
    naturalWidth: 0,
    naturalHeight: 0
};

// ===== Initialize Zoom on Image Load =====
mainImage.addEventListener('load', function() {
    updateImageDimensions();
    zoomImage.src = this.src;
});

// ===== Update Image Dimensions =====
function updateImageDimensions() {
    if (!mainImage.complete || !mainImage.naturalHeight) return;
    
    const rect = mainImageWrapper.getBoundingClientRect();
    imageDimensions = {
        width: rect.width,
        height: rect.height,
        naturalWidth: mainImage.naturalWidth,
        naturalHeight: mainImage.naturalHeight
    };
}

// ===== Change Main Image =====
function changeMainImage(src, element) {
    mainImage.src = src;
    zoomImage.src = src;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail-item').forEach(item => {
        item.classList.remove('active');
    });
    element.classList.add('active');
    
    // Reset zoom
    hideZoom();
    
    // Update dimensions when new image loads
    mainImage.onload = function() {
        updateImageDimensions();
    };
}

// ===== Show Zoom =====
function showZoom() {
    if (window.innerWidth <= 768) return;
    
    isZoomActive = true;
    zoomResult.style.display = 'block';
    zoomLens.style.display = 'block';
    updateImageDimensions();
}

// ===== Hide Zoom =====
function hideZoom() {
    isZoomActive = false;
    zoomResult.style.display = 'none';
    zoomLens.style.display = 'none';
}

// ===== Handle Mouse Enter =====
mainImageWrapper.addEventListener('mouseenter', showZoom);

// ===== Handle Mouse Leave =====
mainImageWrapper.addEventListener('mouseleave', hideZoom);

// ===== Handle Mouse Move for Zoom =====
mainImageWrapper.addEventListener('mousemove', function(e) {
    if (!isZoomActive || window.innerWidth <= 768) return;
    
    const rect = mainImageWrapper.getBoundingClientRect();
    let x = e.clientX - rect.left;
    let y = e.clientY - rect.top;
    
    // Constrain lens position within image bounds
    x = Math.max(LENS_SIZE / 2, Math.min(x, rect.width - LENS_SIZE / 2));
    y = Math.max(LENS_SIZE / 2, Math.min(y, rect.height - LENS_SIZE / 2));
    
    // Position the lens
    zoomLens.style.left = (x - LENS_SIZE / 2) + 'px';
    zoomLens.style.top = (y - LENS_SIZE / 2) + 'px';
    
    // Calculate zoom image position
    const zoomedWidth = rect.width * ZOOM_LEVEL;
    const zoomedHeight = rect.height * ZOOM_LEVEL;
    
    // Position the zoomed image
    const offsetX = -(x * ZOOM_LEVEL - LENS_SIZE / 2);
    const offsetY = -(y * ZOOM_LEVEL - LENS_SIZE / 2);
    
    zoomImage.style.width = zoomedWidth + 'px';
    zoomImage.style.height = zoomedHeight + 'px';
    zoomImage.style.left = offsetX + 'px';
    zoomImage.style.top = offsetY + 'px';
});

// ===== Handle Window Resize =====
window.addEventListener('resize', function() {
    if (window.innerWidth <= 768) {
        hideZoom();
    } else if (isZoomActive) {
        updateImageDimensions();
    }
});

// ===== Initialize on Page Load =====
document.addEventListener('DOMContentLoaded', function() {
    updateImageDimensions();
    if (mainImage.complete) {
        zoomImage.src = mainImage.src;
    }
});
</script>
@endsection