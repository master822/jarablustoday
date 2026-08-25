@extends('layouts.app')

@section('title', 'تواصل مع البائع')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h4 class="text-center mb-4" style="color: var(--text-primary);">
                    <i class="fas fa-envelope me-2"></i>تواصل مع البائع
                </h4>
                
                <div class="product-info mb-4 p-3" style="background: var(--bg-body); border-radius: 12px;">
                    <div class="d-flex gap-3">
                        @php
                            $imageUrl = asset('images/product-placeholder.svg');
                            if ($product->images) {
                                $images = json_decode($product->images, true);
                                if (is_array($images) && count($images) > 0) {
                                    $firstImage = $images[0];
                                    if (!str_starts_with($firstImage, 'http')) {
                                        $imageUrl = asset('storage/' . $firstImage);
                                    } else {
                                        $imageUrl = $firstImage;
                                    }
                                }
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" 
                             alt="{{ $product->name }}"
                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 12px;">
                        <div>
                            <h5 style="color: var(--text-primary);">{{ $product->name }}</h5>
                            <p style="color: var(--text-muted);">
                                <i class="fas fa-store me-1"></i>
                                {{ $product->user->store_name ?? $product->user->name ?? 'غير معروف' }}
                            </p>
                            <span style="color: var(--primary-color); font-weight: 700;">
                                {{ number_format($product->price ?? 0, 2) }} TL
                            </span>
                        </div>
                    </div>
                </div>
                
<form action="{{ url('/messages/contact/' . $product->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="message" class="form-label" style="color: var(--text-primary);">الرسالة</label>
        <textarea name="message" id="message" class="form-control form-rizk" rows="5" 
                  placeholder="اكتب رسالتك هنا..." required></textarea>
        @error('message')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    <div class="d-grid gap-2">
        <button type="submit" class="btn btn-rizk-primary">
            <i class="fas fa-paper-plane me-2"></i>إرسال الرسالة
        </button>
        <a href="{{ route('products.show', $product->id) }}" class="btn btn-rizk-outline">إلغاء</a>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
@endsection
