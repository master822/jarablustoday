@extends('layouts.app')

@section('title', 'بحث الخدمات')

@section('content')
<div class="container py-4">
    <h2 class="section-title-rizk mb-4">🔍 بحث الخدمات</h2>
    
    <!-- نموذج البحث -->
    <div class="card-rizk p-4 mb-4">
        <form action="{{ route('search.services') }}" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <label style="color: var(--text-primary);">كلمة البحث</label>
                    <input type="text" name="q" class="form-control form-rizk" placeholder="ابحث عن خدمة..." value="{{ request('q') }}">
                </div>
                <div class="col-md-3">
                    <label style="color: var(--text-primary);">نوع الخدمة</label>
                    <select name="service_type" class="form-select form-rizk">
                        <option value="">جميع الخدمات</option>
                        <option value="cooking" {{ request('service_type') == 'cooking' ? 'selected' : '' }}>طبخ منزل</option>
                        <option value="vegetables" {{ request('service_type') == 'vegetables' ? 'selected' : '' }}>تجهيز خضار</option>
                        <option value="transport" {{ request('service_type') == 'transport' ? 'selected' : '' }}>سيارة نقل</option>
                        <option value="hire-worker" {{ request('service_type') == 'hire-worker' ? 'selected' : '' }}>استأجر عامل</option>
                        <option value="hire-technician" {{ request('service_type') == 'hire-technician' ? 'selected' : '' }}>استأجر فني</option>
                        <option value="cleaning_company" {{ request('service_type') == 'cleaning_company' ? 'selected' : '' }}>ورشة تنظيف</option>
                        <option value="other" {{ request('service_type') == 'other' ? 'selected' : '' }}>خدمات أخرى</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label style="color: var(--text-primary);">المدينة</label>
                    <select name="city" class="form-select form-rizk">
                        <option value="">جميع المدن</option>
                        <option value="دمشق" {{ request('city') == 'دمشق' ? 'selected' : '' }}>دمشق</option>
                        <option value="حلب" {{ request('city') == 'حلب' ? 'selected' : '' }}>حلب</option>
                        <option value="حمص" {{ request('city') == 'حمص' ? 'selected' : '' }}>حمص</option>
                        <option value="اللاذقية" {{ request('city') == 'اللاذقية' ? 'selected' : '' }}>اللاذقية</option>
                        <option value="حماة" {{ request('city') == 'حماة' ? 'selected' : '' }}>حماة</option>
                        <option value="طرطوس" {{ request('city') == 'طرطوس' ? 'selected' : '' }}>طرطوس</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label style="color: var(--text-primary);">&nbsp;</label>
                    <button type="submit" class="btn btn-rizk-primary w-100">
                        <i class="fas fa-search me-2"></i>بحث
                    </button>
                </div>
            </div>
        </form>
        <div class="mt-2">
            <a href="{{ route('search.services') }}" class="btn btn-rizk-outline btn-sm">
                <i class="fas fa-undo me-1"></i>مسح البحث
            </a>
        </div>
    </div>
    
    <!-- النتائج -->
    <div class="row g-4">
        @forelse($services as $service)
            <div class="col-md-4 col-lg-3">
                <div class="card-rizk p-3 hover-lift">
                    @php
                        $imageUrl = asset('images/product-placeholder.svg');
                        if ($service->images) {
                            $images = json_decode($service->images, true);
                            if (is_array($images) && count($images) > 0 && $images[0]) {
                                if (file_exists(storage_path('app/public/' . $images[0]))) {
                                    $imageUrl = asset('storage/' . $images[0]);
                                }
                            }
                        }
                    @endphp
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $service->service_name }}"
                         style="width: 100%; height: 150px; object-fit: cover; border-radius: 8px; margin-bottom: 10px;"
                         onerror="this.onerror=null; this.style.display='none';">
                    
                    <h6 style="color: var(--text-primary);">{{ $service->service_name }}</h6>
                    <p class="small text-muted">{{ Str::limit($service->description, 50) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="color: var(--text-muted); font-size: 0.75rem;">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $service->city ?? 'غير محدد' }}
                        </span>
                        @if($service->price)
                            <span style="color: var(--primary-color); font-weight: 700; font-size: 0.85rem;">
                                {{ number_format($service->price, 2) }} $
                            </span>
                        @endif
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('merchants.show', $service->user_id) }}" 
                           class="btn btn-rizk-primary btn-sm w-100">
                            <i class="fas fa-eye me-1"></i>عرض التفاصيل
                        </a>
                    </div>
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
    
    @if($services->hasPages())
        <div class="pagination-simple mt-4">
            {{ $services->appends(request()->query())->links('pagination::bootstrap-5') }}
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
