@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <!-- ===== عرض الصور مثل AliExpress ===== -->
                    @php
                        $images = is_array($product->images) ? $product->images : json_decode($product->images, true);
                        $firstImage = ($images && count($images) > 0) ? $images[0] : null;
                    @endphp

                    <div class="row">
                        <!-- الصور المصغرة على اليمين -->
                        @if($images && count($images) > 0)
                            <div class="col-2 order-md-2">
                                <div class="thumbnail-container">
                                    @foreach($images as $index => $image)
                                        <div class="thumbnail-item {{ $index == 0 ? 'active' : '' }}" 
                                             onclick="changeMainImage('{{ asset('storage/' . $image) }}', this)">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="img-fluid rounded">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            
                            <!-- الصورة الرئيسية -->
                            <div class="col-10 order-md-1">
                                <div class="main-image-container">
                                    <div class="main-image-wrapper">
                                        <img id="mainImage" 
                                             src="{{ $firstImage ? asset('storage/' . $firstImage) : asset('images/no-image.png') }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-fluid main-product-image">
                                        
                                        <!-- منطقة التكبير -->
                                        <div class="zoom-lens" id="zoomLens"></div>
                                    </div>
                                    <!-- صورة التكبير المنبثقة -->
                                    <div class="zoom-result" id="zoomResult">
                                        <img id="zoomImage" src="" alt="تكبير الصورة">
                                    </div>
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
                    
                    <h2 class="mt-4">{{ $product->name }}</h2>
                    
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

@push('styles')
<style>
/* ===== تنسيق الصور المصغرة ===== */
.thumbnail-container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-height: 400px;
    overflow-y: auto;
    padding-left: 5px;
}

.thumbnail-item {
    cursor: pointer;
    border: 2px solid transparent;
    border-radius: 8px;
    transition: all 0.3s ease;
    padding: 2px;
}

.thumbnail-item:hover {
    border-color: #d4af37;
}

.thumbnail-item.active {
    border-color: #d4af37;
    box-shadow: 0 0 10px rgba(212, 175, 55, 0.3);
}

.thumbnail-item img {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 6px;
}

/* ===== الصورة الرئيسية والتكبير ===== */
.main-image-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    cursor: crosshair;
    border-radius: 8px;
    background: #f8f9fa;
}

.main-image-wrapper {
    position: relative;
    width: 100%;
    padding-bottom: 75%; /* نسبة 4:3 */
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
    background: rgba(212, 175, 55, 0.2);
    border: 2px solid #d4af37;
    border-radius: 4px;
    display: none;
    pointer-events: none;
    z-index: 5;
}

/* ===== نافذة التكبير ===== */
.zoom-result {
    display: none;
    position: absolute;
    top: 0;
    right: -105%;
    width: 100%;
    height: 100%;
    border: 2px solid #d4af37;
    border-radius: 8px;
    background: #fff;
    overflow: hidden;
    z-index: 10;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.zoom-result img {
    position: absolute;
    top: 0;
    left: 0;
    width: 200%;
    height: 200%;
    object-fit: contain;
}

/* ===== تحسين للشاشات الصغيرة ===== */
@media (max-width: 768px) {
    .thumbnail-container {
        flex-direction: row;
        max-height: none;
        overflow-x: auto;
        overflow-y: hidden;
    }
    
    .thumbnail-item img {
        height: 60px;
        width: 60px;
    }
    
    .main-image-wrapper {
        padding-bottom: 100%;
    }
    
    .zoom-result {
        display: none !important;
    }
    
    .zoom-lens {
        display: none !important;
    }
}
</style>
@endpush

@push('scripts')
<script>
let mainImage = document.getElementById('mainImage');
let zoomResult = document.getElementById('zoomResult');
let zoomImage = document.getElementById('zoomImage');
let zoomLens = document.getElementById('zoomLens');
let mainContainer = document.querySelector('.main-image-container');

// ===== تغيير الصورة الرئيسية عند النقر على صورة مصغرة =====
function changeMainImage(src, element) {
    // تحديث الصورة الرئيسية
    mainImage.src = src;
    
    // تحديث صورة التكبير
    zoomImage.src = src;
    
    // تحديث الحالة النشطة
    document.querySelectorAll('.thumbnail-item').forEach(item => {
        item.classList.remove('active');
    });
    element.classList.add('active');
    
    // إعادة ضبط التكبير
    zoomResult.style.display = 'none';
    zoomLens.style.display = 'none';
}

// ===== حدث التكبير عند تمرير الماوس =====
mainContainer.addEventListener('mouseenter', function() {
    if (window.innerWidth > 768) {
        zoomResult.style.display = 'block';
        zoomLens.style.display = 'block';
    }
});

mainContainer.addEventListener('mouseleave', function() {
    zoomResult.style.display = 'none';
    zoomLens.style.display = 'none';
});

// ===== تحريك عدسة التكبير =====
mainContainer.addEventListener('mousemove', function(e) {
    if (window.innerWidth <= 768) return;
    
    const rect = this.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    // حدود العدسة
    const lensWidth = zoomLens.offsetWidth;
    const lensHeight = zoomLens.offsetHeight;
    
    let left = x - lensWidth / 2;
    let top = y - lensHeight / 2;
    
    // منع خروج العدسة عن الصورة
    left = Math.max(0, Math.min(left, rect.width - lensWidth));
    top = Math.max(0, Math.min(top, rect.height - lensHeight));
    
    zoomLens.style.left = left + 'px';
    zoomLens.style.top = top + 'px';
    
    // تحديث صورة التكبير
    const scaleX = (rect.width / lensWidth) * 2;
    const scaleY = (rect.height / lensHeight) * 2;
    
    zoomImage.style.width = (rect.width * scaleX) + 'px';
    zoomImage.style.height = (rect.height * scaleY) + 'px';
    zoomImage.style.left = -(left * scaleX) + 'px';
    zoomImage.style.top = -(top * scaleY) + 'px';
});

// ===== إعادة ضبط عند تغيير حجم الشاشة =====
window.addEventListener('resize', function() {
    if (window.innerWidth <= 768) {
        zoomResult.style.display = 'none';
        zoomLens.style.display = 'none';
    }
});
</script>
@endpush
@endsection