@extends('layouts.app')

@section('title', 'إضافة خدمة جديدة')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4 class="mb-0">إضافة خدمة جديدة</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('service-provider.services.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">اسم الخدمة</label>
                            <input type="text" class="form-control" name="service_name" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea class="form-control" name="description" rows="4" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">المدينة</label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">السعر (اختياري)</label>
                            <input type="number" class="form-control" name="price" step="0.01">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">نوع السعر</label>
                            <select class="form-control" name="price_type">
                                <option value="fixed">ثابت</option>
                                <option value="hourly">بالساعة</option>
                                <option value="daily">باليوم</option>
                                <option value="negotiable">قابل للتفاوض</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn w-100" style="background: #d4af37; color: white;">إضافة الخدمة</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
