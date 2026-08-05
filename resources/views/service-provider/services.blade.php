@extends('layouts.app')

@section('title', 'خدماتي')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>خدماتي</h2>
        <a href="{{ route('service-provider.services.create') }}" class="btn" style="background: #d4af37; color: white;">
            <i class="fas fa-plus"></i> إضافة خدمة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($services->count() > 0)
        <div class="row">
            @foreach($services as $service)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $service->service_name }}</h5>
                            <p class="card-text">{{ Str::limit($service->description, 100) }}</p>
                            <p><strong>المدينة:</strong> {{ $service->city ?? 'غير محدد' }}</p>
                            @if($service->price)
                                <p><strong>السعر:</strong> {{ $service->price }} ل.س</p>
                            @endif
                            <p><strong>الحالة:</strong> {{ $service->is_active ? 'نشط' : 'غير نشط' }}</p>
                        </div>
                        <div class="card-footer d-flex gap-2">
                            <a href="{{ route('service-provider.services.edit', $service->id) }}" class="btn btn-sm btn-warning flex-fill">تعديل</a>
                            <form action="{{ route('service-provider.services.delete', $service->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('هل أنت متأكد من حذف هذه الخدمة؟')">حذف</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $services->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> لا توجد خدمات مضافة حالياً.
            <a href="{{ route('service-provider.services.create') }}" class="btn btn-sm" style="background: #d4af37; color: white;">أضف خدمة الآن</a>
        </div>
    @endif
</div>
@endsection
