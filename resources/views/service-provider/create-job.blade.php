@extends('layouts.app')

@section('title', 'نشر فرصة عمل جديدة')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h5 style="color: var(--text-primary);">نشر فرصة عمل جديدة</h5>
                <form action="{{ route('service-provider.jobs.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">عنوان الوظيفة *</label>
                        <input type="text" name="title" class="form-control form-rizk" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الوصف *</label>
                        <textarea name="description" class="form-control form-rizk" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">نوع الوظيفة *</label>
                        <select name="category" class="form-select form-rizk" required>
                            <option value="full_time">دوام كامل</option>
                            <option value="part_time">دوام جزئي</option>
                            <option value="freelance">عمل حر</option>
                            <option value="temporary">مؤقت</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الموقع</label>
                        <input type="text" name="location" class="form-control form-rizk">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: var(--text-primary);">الحد الأدنى للراتب</label>
                                <input type="number" name="salary_min" class="form-control form-rizk" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: var(--text-primary);">الحد الأقصى للراتب</label>
                                <input type="number" name="salary_max" class="form-control form-rizk" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">نوع الراتب</label>
                        <select name="salary_type" class="form-select form-rizk">
                            <option value="hourly">ساعة</option>
                            <option value="daily">يومي</option>
                            <option value="weekly">أسبوعي</option>
                            <option value="monthly" selected>شهري</option>
                            <option value="yearly">سنوي</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">تاريخ الانتهاء</label>
                        <input type="date" name="expires_at" class="form-control form-rizk">
                    </div>
                    <button type="submit" class="btn btn-rizk-primary">نشر الوظيفة</button>
                    <a href="{{ route('service-provider.jobs') }}" class="btn btn-rizk-outline">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
