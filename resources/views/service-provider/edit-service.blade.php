@extends('layouts.app')

@section('title', 'تعديل الخدمة')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4 class="mb-0">تعديل الخدمة</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('service-provider.services.update', $service->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">اسم الخدمة</label>
                            <input type="text" class="form-control" name="service_name" value="{{ $service->service_name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" name="description" rows="4" required>{{ $service->description }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">المدينة</label>
                            <input type="text" class="form-control" name="city" value="{{ $service->city }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">السعر (اختياري)</label>
                            <input type="number" class="form-control" name="price" value="{{ $service->price }}" step="0.01">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">نوع السعر</label>
                            <select class="form-control" name="price_type">
                                <option value="fixed" {{ $service->price_type == 'fixed' ? 'selected' : '' }}>ثابت</option>
                                <option value="hourly" {{ $service->price_type == 'hourly' ? 'selected' : '' }}>بالساعة</option>
                                <option value="daily" {{ $service->price_type == 'daily' ? 'selected' : '' }}>باليوم</option>
                                <option value="negotiable" {{ $service->price_type == 'negotiable' ? 'selected' : '' }}>قابل للتفاوض</option>
                            </select>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" {{ $service->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">نشط</label>
                        </div>
                        
                        <button type="submit" class="btn w-100" style="background: #d4af37; color: white;">حفظ التغييرات</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
