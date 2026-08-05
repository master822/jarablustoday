@extends('layouts.app')

@section('title', 'بحث المتاجر')

@section('content')
<div class="container py-4">
    <h2 class="section-title-rizk mb-4">🔍 بحث المتاجر</h2>
    
    <div class="card-rizk p-4 mb-4">
        <form action="{{ route('search.merchants') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-8">
                    <label style="color: var(--text-primary);">كلمة البحث</label>
                    <input type="text" name="q" class="form-control form-rizk" placeholder="ابحث عن تاجر..." value="{{ request('q') }}">
                </div>
                <div class="col-md-4">
                    <label style="color: var(--text-primary);">&nbsp;</label>
                    <button type="submit" class="btn btn-rizk-primary w-100">
                        <i class="fas fa-search me-2"></i>بحث
                    </button>
                </div>
            </div>
        </form>
        <div class="mt-2">
            <a href="{{ route('search.merchants') }}" class="btn btn-rizk-outline btn-sm">
                <i class="fas fa-undo me-1"></i>مسح البحث
            </a>
        </div>
    </div>
    
    <div class="row g-4">
        @forelse($merchants as $merchant)
            <div class="col-md-4 col-lg-3">
                <div class="card-rizk text-center p-4 hover-lift">
                    @if($merchant->store_logo)
                        <img src="{{ asset('storage/' . $merchant->store_logo) }}" 
                             alt="{{ $merchant->store_name }}"
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; margin: 0 auto 10px; border: 3px solid var(--primary-color);">
                    @elseif($merchant->avatar)
                        <img src="{{ asset('storage/' . $merchant->avatar) }}" 
                             alt="{{ $merchant->name }}"
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; margin: 0 auto 10px; border: 3px solid var(--primary-color);">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($merchant->store_name ?? $merchant->name) }}&size=80&background=d4af37&color=fff" 
                             alt="{{ $merchant->name }}"
                             style="width: 80px; height: 80px; border-radius: 50%; margin: 0 auto 10px;">
                    @endif
                    
                    <h6 style="color: var(--text-primary);">{{ $merchant->store_name ?? $merchant->name }}</h6>
                    <p class="small text-muted">{{ Str::limit($merchant->store_description, 50) }}</p>
                    <p style="color: var(--text-muted); font-size: 0.75rem;">
                        <i class="fas fa-map-marker-alt me-1"></i>{{ $merchant->city ?? 'غير محدد' }}
                    </p>
                    <a href="{{ route('merchants.show', $merchant->id) }}" 
                       class="btn btn-rizk-primary btn-sm w-100">
                        <i class="fas fa-store me-1"></i>زيارة المتجر
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-search fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد نتائج</h5>
                <p style="color: var(--text-muted);">حاول تغيير كلمات البحث</p>
            </div>
        @endforelse
    </div>
    
    @if($merchants->hasPages())
        <div class="pagination-simple mt-4">
            {{ $merchants->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<style>
    .hover-lift {
        transition: all 0.3s ease;
    }
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }
</style>
@endsection
