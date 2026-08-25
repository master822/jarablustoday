@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="section-title-rizk text-center mb-4">جميع الخدمات</h2>
    
    @if($services->count() > 0)
        <div class="row">
            @foreach($services as $service)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->service_name }}</h5>
                            <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                            <p><strong>المدينة:</strong> {{ $service->city ?? 'غير محدد' }}</p>
                            <p><strong>مقدم الخدمة:</strong> {{ $service->user->name ?? 'غير معروف' }}</p>
                            <a href="{{ route('services.show', $service->id) }}" class="btn" style="background: #d4af37; color: white;">عرض التفاصيل</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $services->links() }}
    @else
            <div class="col-12 text-center py-5">
                <i class="fas fa-tag fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد خدمات حالياً</h5>
                <p style="color: var(--text-muted);">ترقبوا الخدمات القادمة!</p>
            </div>
    @endif
</div>
@endsection
