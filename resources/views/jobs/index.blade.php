@extends('layouts.app')

@section('title', 'فرص العمل')

@section('content')
<div class="container py-4">
    <h1 class="section-title-rizk text-center mb-4">فرص العمل</h1>
    
    <div class="row g-4">
        @forelse($jobs as $job)
            <div class="col-md-6 col-lg-4">
                <div class="card-rizk p-4 hover-lift">
                    <div class="d-flex justify-content-between align-items-start">
                        <h5 style="color: var(--text-primary);">{{ $job->title }}</h5>
                        <span class="badge-rizk badge-rizk-gold">{{ $job->category_name }}</span>
                    </div>
                    <p style="color: var(--text-muted);" class="mt-2">{{ Str::limit($job->description, 120) }}</p>
                    <div class="d-flex justify-content-between mt-3">
                        <span style="color: var(--text-muted);">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $job->location ?? 'غير محدد' }}
                        </span>
                        @if($job->salary_min)
                            <span style="color: var(--primary-color); font-weight: 700;">
                                {{ number_format($job->salary_min, 2) }} - {{ number_format($job->salary_max, 2) }} {{ $job->salary_type }}
                            </span>
                        @endif
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-rizk-primary btn-sm flex-fill">عرض التفاصيل</a>
                        @auth
                            <a href="{{ route('messages.contact.job', $job->id) }}" class="btn btn-rizk-outline btn-sm flex-fill">تواصل</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-rizk-outline btn-sm flex-fill">سجل للتواصل</a>
                        @endauth
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-briefcase fa-3x gold-text mb-3"></i>
                <h5 style="color: var(--text-primary);">لا توجد فرص عمل حالياً</h5>
                <p style="color: var(--text-muted);">كن أول من ينشر فرصة عمل!</p>
            </div>
        @endforelse
    </div>
    
    <div class="pagination-simple mt-4">
        {{ $jobs->links('pagination::bootstrap-5') }}
    </div>
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
