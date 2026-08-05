@extends('layouts.app')

@section('title', 'تعديل فرصة عمل')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h5 style="color: var(--text-primary);">تعديل فرصة العمل</h5>
                <form action="{{ route('merchant.jobs.update', $job->id) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">عنوان الوظيفة *</label>
                        <input type="text" name="title" class="form-control form-rizk" value="{{ $job->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الوصف *</label>
                        <textarea name="description" class="form-control form-rizk" rows="5" required>{{ $job->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">نوع الوظيفة *</label>
                        <select name="category" class="form-select form-rizk" required>
                            <option value="full_time" {{ $job->category == 'full_time' ? 'selected' : '' }}>دوام كامل</option>
                            <option value="part_time" {{ $job->category == 'part_time' ? 'selected' : '' }}>دوام جزئي</option>
                            <option value="freelance" {{ $job->category == 'freelance' ? 'selected' : '' }}>عمل حر</option>
                            <option value="temporary" {{ $job->category == 'temporary' ? 'selected' : '' }}>مؤقت</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الموقع</label>
                        <input type="text" name="location" class="form-control form-rizk" value="{{ $job->location }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: var(--text-primary);">الحد الأدنى للراتب</label>
                                <input type="number" name="salary_min" class="form-control form-rizk" step="0.01" value="{{ $job->salary_min }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label style="color: var(--text-primary);">الحد الأقصى للراتب</label>
                                <input type="number" name="salary_max" class="form-control form-rizk" step="0.01" value="{{ $job->salary_max }}">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">نوع الراتب</label>
                        <select name="salary_type" class="form-select form-rizk">
                            <option value="hourly" {{ $job->salary_type == 'hourly' ? 'selected' : '' }}>ساعة</option>
                            <option value="daily" {{ $job->salary_type == 'daily' ? 'selected' : '' }}>يومي</option>
                            <option value="weekly" {{ $job->salary_type == 'weekly' ? 'selected' : '' }}>أسبوعي</option>
                            <option value="monthly" {{ $job->salary_type == 'monthly' ? 'selected' : '' }}>شهري</option>
                            <option value="yearly" {{ $job->salary_type == 'yearly' ? 'selected' : '' }}>سنوي</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">حالة الوظيفة</label>
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $job->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active" style="color: var(--text-primary);">نشطة</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">تاريخ الانتهاء</label>
                        <input type="date" name="expires_at" class="form-control form-rizk" value="{{ $job->expires_at ? $job->expires_at->format('Y-m-d') : '' }}">
                    </div>
                    <button type="submit" class="btn btn-rizk-primary">تحديث الوظيفة</button>
                    <a href="{{ route('merchant.jobs') }}" class="btn btn-rizk-outline">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
