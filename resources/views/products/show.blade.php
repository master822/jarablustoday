@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <!-- ===== صور المنتج ===== -->
                    @if($product->images)
                        <div class="row mb-4">
                            @php
                                $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                            @endphp
                            @if($images && count($images) > 0)
                                <div class="col-12">
                                    <div class="row g-2">
                                        @foreach($images as $image)
                                            <div class="col-4">
                                                <img src="{{ asset('storage/' . $image) }}" 
                                                     alt="{{ $product->name }}" 
                                                     class="img-fluid rounded product-thumbnail"
                                                     style="width: 100%; height: 150px; object-fit: cover; cursor: pointer;"
                                                     onclick="openLightbox(this.src)">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="col-12 text-center">
                                    <div class="bg-light p-5 rounded">
                                        <i class="fas fa-image fa-4x text-muted"></i>
                                        <p class="text-muted mt-2">لا توجد صور لهذا المنتج</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <h2>{{ $product->name }}</h2>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>💰 السعر:</strong> <span style="color: #d4af37; font-size: 1.5rem; font-weight: bold;">{{ number_format($product->price, 0) }} ل.س</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>📦 الكمية المتاحة:</strong> 
                                <span class="badge" style="background: #d4af37; color: white; font-size: 1rem; padding: 5px 15px;">
                                    {{ $product->quantity ?? 1 }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <p><strong>📝 الوصف:</strong></p>
                    <p>{{ $product->description }}</p>
                    
                    <p><strong>📌 الحالة:</strong> 
                        <span class="badge" style="background: #17a2b8; color: white;">
                            {{ $product->condition ?? 'جديد' }}
                        </span>
                    </p>
                    
                    <p><strong>👤 البائع:</strong> {{ $product->user->name ?? 'غير معروف' }}</p>
                    
                    <p><strong>📅 تاريخ الإضافة:</strong> {{ $product->created_at ? $product->created_at->format('Y-m-d') : 'غير معروف' }}</p>
                    
                    <div class="mt-4">
                        @auth
                            @if(Auth::id() != $product->user_id)
                                <a href="{{ route('messages.contact.form', $product->id) }}" class="btn" style="background: #28a745; color: white;">
                                    <i class="fas fa-envelope"></i> التواصل مع البائع
                                </a>
                            @else
                                <span class="text-muted">هذا المنتج خاص بك</span>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn" style="background: #28a745; color: white;">
                                <i class="fas fa-sign-in-alt"></i> سجل الدخول للتواصل
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== Lightbox لتكبير الصورة ===== -->
<div id="lightbox" class="lightbox">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <div class="lightbox-controls">
        <button class="lightbox-btn" onclick="zoomIn()">➕</button>
        <button class="lightbox-btn" onclick="zoomOut()">➖</button>
        <button class="lightbox-btn" onclick="resetZoom()">⟲</button>
    </div>
    <div class="lightbox-container">
        <div class="lightbox-wrapper" id="lightboxWrapper">
            <img id="lightboxImage" src="" alt="صورة المنتج">
        </div>
    </div>
</div>

@push('styles')
<style>
/* ===== Lightbox Styles ===== */
.lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    z-index: 9999;
    overflow: hidden;
}

.lightbox.active {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.lightbox-close {
    position: fixed;
    top: 20px;
    right: 35px;
    color: #fff;
    font-size: 40px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
    z-index: 10001;
    background: rgba(0,0,0,0.5);
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
}

.lightbox-close:hover {
    color: #d4af37;
    transform: scale(1.1);
}

.lightbox-controls {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 15px;
    background: rgba(0, 0, 0, 0.7);
    padding: 12px 25px;
    border-radius: 30px;
    z-index: 10001;
}

.lightbox-btn {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 24px;
    padding: 8px 15px;
    cursor: pointer;
    border-radius: 8px;
    transition: 0.3s;
}

.lightbox-btn:hover {
    background: rgba(212, 175, 55, 0.3);
    color: #d4af37;
    transform: scale(1.1);
}

.lightbox-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px;
    overflow: hidden;
}

.lightbox-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
    transition: transform 0.3s ease;
    cursor: grab;
}

.lightbox-wrapper:active {
    cursor: grabbing;
}

#lightboxImage {
    max-width: 90%;
    max-height: 85%;
    object-fit: contain;
    transition: transform 0.2s ease;
    user-select: none;
    -webkit-user-drag: none;
}

.product-thumbnail {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-thumbnail:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
}

@media (max-width: 768px) {
    .lightbox-close {
        top: 10px;
        right: 15px;
        font-size: 30px;
        width: 40px;
        height: 40px;
    }
    
    .lightbox-controls {
        bottom: 20px;
        padding: 8px 15px;
        gap: 8px;
    }
    
    .lightbox-btn {
        font-size: 18px;
        padding: 5px 10px;
    }
    
    .lightbox-container {
        padding: 40px 20px;
    }
}
</style>
@endpush

@push('scripts')
<script>
let currentZoom = 1;
let panX = 0;
let panY = 0;
let isDragging = false;
let startX, startY, startPanX, startPanY;
let wrapper = document.getElementById('lightboxWrapper');
let image = document.getElementById('lightboxImage');

function openLightbox(src) {
    document.getElementById('lightbox').classList.add('active');
    document.getElementById('lightboxImage').src = src;
    resetZoom();
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
    resetZoom();
}

function zoomIn() {
    currentZoom = Math.min(currentZoom + 0.2, 5);
    updateTransform();
}

function zoomOut() {
    currentZoom = Math.max(currentZoom - 0.2, 0.5);
    updateTransform();
}

function resetZoom() {
    currentZoom = 1;
    panX = 0;
    panY = 0;
    updateTransform();
}

function updateTransform() {
    image.style.transform = `scale(${currentZoom}) translate(${panX}px, ${panY}px)`;
}

// ===== السحب والتحريك بالماوس =====
wrapper.addEventListener('mousedown', function(e) {
    if (currentZoom > 1) {
        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;
        startPanX = panX;
        startPanY = panY;
        this.style.cursor = 'grabbing';
    }
});

window.addEventListener('mousemove', function(e) {
    if (isDragging) {
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        panX = startPanX + dx;
        panY = startPanY + dy;
        updateTransform();
    }
});

window.addEventListener('mouseup', function() {
    isDragging = false;
    wrapper.style.cursor = currentZoom > 1 ? 'grab' : 'default';
});

// ===== السحب باللمس للهواتف =====
let touchStartX, touchStartY, touchPanX, touchPanY;

wrapper.addEventListener('touchstart', function(e) {
    if (currentZoom > 1 && e.touches.length === 1) {
        const touch = e.touches[0];
        touchStartX = touch.clientX;
        touchStartY = touch.clientY;
        touchPanX = panX;
        touchPanY = panY;
    }
}, { passive: true });

wrapper.addEventListener('touchmove', function(e) {
    if (currentZoom > 1 && e.touches.length === 1) {
        const touch = e.touches[0];
        const dx = touch.clientX - touchStartX;
        const dy = touch.clientY - touchStartY;
        panX = touchPanX + dx;
        panY = touchPanY + dy;
        updateTransform();
    }
}, { passive: true });

// ===== التكبير باستخدام عجلة الماوس =====
wrapper.addEventListener('wheel', function(e) {
    e.preventDefault();
    if (e.deltaY < 0) {
        zoomIn();
    } else {
        zoomOut();
    }
}, { passive: false });

// ===== إغلاق الضوء بالضغط على ESC =====
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeLightbox();
    }
});

// ===== إغلاق بالضغط خارج الصورة =====
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>
@endpush
@endsection