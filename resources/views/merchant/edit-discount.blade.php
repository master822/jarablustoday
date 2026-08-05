@extends('layouts.app')

@section('title', 'تعديل التخفيض')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h5 style="color: var(--text-primary);">تعديل التخفيض</h5>
                <form action="{{ route('merchant.discounts.update', $discount->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">اسم التخفيض *</label>
                        <input type="text" name="name" class="form-control form-rizk" value="{{ $discount->name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">وصف التخفيض</label>
                        <textarea name="description" class="form-control form-rizk" rows="3">{{ $discount->description }}</textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">نسبة التخفيض *</label>
                        <input type="number" name="percentage" class="form-control form-rizk" min="1" max="100" value="{{ $discount->percentage }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">المنتج</label>
                        @php
                            $product = $discount->product;
                        @endphp
                        @if($product)
                            <p style="color: var(--text-primary);">
                                <i class="fas fa-box me-1"></i>
                                {{ $product->name }} - {{ number_format($product->price, 2) }} TL
                            </p>
                        @else
                            <p style="color: var(--text-muted);">المنتج غير موجود</p>
                        @endif
                    </div>
                    
                    <button type="submit" class="btn btn-rizk-primary w-100">تحديث التخفيض</button>
                    <a href="{{ route('merchant.discounts') }}" class="btn btn-rizk-outline w-100 mt-2">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
