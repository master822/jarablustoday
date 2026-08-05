@extends('layouts.app')

@section('title', 'فرص العمل')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>فرص العمل</h2>
        <a href="{{ route('service-provider.jobs.create') }}" class="btn" style="background: #d4af37; color: white;">
            <i class="fas fa-plus"></i> إضافة فرصة عمل
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($jobs->count() > 0)
        <div class="row">
            @foreach($jobs as $job)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $job->title }}</h5>
                            <p class="card-text">{{ Str::limit($job->description, 100) }}</p>
                            <p><strong>الفئة:</strong> {{ $job->category }}</p>
                            <p><strong>الموقع:</strong> {{ $job->location ?? 'غير محدد' }}</p>
                            @if($job->salary_min || $job->salary_max)
                                <p><strong>الراتب:</strong> {{ $job->salary_min ?? '' }} - {{ $job->salary_max ?? '' }}</p>
                            @endif
                            <p><strong>الحالة:</strong> {{ $job->is_active ? 'نشط' : 'غير نشط' }}</p>
                        </div>
                        <div class="card-footer d-flex gap-2">
                            <a href="{{ route('service-provider.jobs.edit', $job->id) }}" class="btn btn-sm btn-warning flex-fill">تعديل</a>
                            <form action="{{ route('service-provider.jobs.delete', $job->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-4">
            {{ $jobs->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> لا توجد فرص عمل مضافة حالياً.
            <a href="{{ route('service-provider.jobs.create') }}" class="btn btn-sm" style="background: #d4af37; color: white;">أضف فرصة عمل الآن</a>
        </div>
    @endif
</div>
@endsection
