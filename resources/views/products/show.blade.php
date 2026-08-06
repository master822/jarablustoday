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
                                                     class="img-fluid rounded" 
                                                     style="width: 100%; height: 150px; object-fit: cover; cursor: pointer;"
                                                     onclick="openImage(this.src)">
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

<!-- ===== مودال عرض الصورة ===== -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #d4af37; color: white;">
                <h5 class="modal-title">صورة المنتج</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="صورة المنتج" class="img-fluid" style="max-height: 500px;">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openImage(src) {
    document.getElementById('modalImage').src = src;
    var modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}
</script>
@endpush

@push('styles')
<style>
.img-thumbnail {
    cursor: pointer;
    transition: transform 0.3s ease;
}
.img-thumbnail:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
</style>
@endpush
@endsection