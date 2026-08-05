@extends('layouts.app')

@section('title', 'فرص العمل')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title-rizk">فرص العمل المنشورة</h4>
        <a href="{{ route('merchant.jobs.create') }}" class="btn btn-rizk-primary">+ نشر فرصة عمل</a>
    </div>

    <div class="row g-3">
        @forelse($jobs as $job)
        <div class="col-md-6">
            <div class="card-rizk p-3">
                <div class="d-flex justify-content-between">
                    <h6 style="color: var(--text-primary);">{{ $job->title }}</h6>
                    <span class="badge-rizk badge-rizk-gold">{{ $job->category_name }}</span>
                </div>
                <p class="small" style="color: var(--text-muted);">{{ Str::limit($job->description, 100) }}</p>
                <div class="d-flex justify-content-between small">
                    <span style="color: var(--text-muted);"><i class="fas fa-map-marker-alt me-1"></i>{{ $job->location ?? 'غير محدد' }}</span>
                    <span style="color: var(--text-muted);">
                        @if($job->salary_min)
                            {{ number_format($job->salary_min, 2) }} - {{ number_format($job->salary_max, 2) }} {{ $job->salary_type }}
                        @else
                            غير محدد
                        @endif
                    </span>
                    <span class="{{ $job->is_active ? 'text-success' : 'text-danger' }}">
                        {{ $job->is_active ? 'نشط' : 'منتهي' }}
                    </span>
                </div>
                <div class="mt-2">
                    <a href="{{ route('merchant.jobs.edit', $job->id) }}" class="btn btn-sm btn-rizk-outline">تعديل</a>
                    <form action="{{ route('merchant.jobs.delete', $job->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card-rizk text-center p-5">
                <i class="fas fa-briefcase fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد فرص عمل</h5>
                <a href="{{ route('merchant.jobs.create') }}" class="btn btn-rizk-primary">نشر فرصة عمل</a>
            </div>
        </div>
        @endforelse
    </div>
    {{ $jobs->links() }}
</div>
@endsection
