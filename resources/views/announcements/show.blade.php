@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
<div class="container py-5" dir="rtl">

    <div class="mb-4">
        <a
            href="{{ route('announcements.index') }}"
            class="btn btn-outline-secondary"
        >
            <i class="fas fa-arrow-right me-1"></i>
            العودة إلى الإعلانات
        </a>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden">

        @if($announcement->image)

            <img
                src="{{ asset('storage/' . $announcement->image) }}"
                alt="{{ $announcement->title }}"
                class="w-100"
                style="max-height:500px; object-fit:cover;"
            >

        @endif

        <div class="card-body p-4 p-md-5">

            <h1 class="fw-bold mb-4">
                {{ $announcement->title }}
            </h1>

            <div class="d-flex flex-wrap gap-3 text-muted small mb-4">

                @if($announcement->user)
                    <span>
                        <i class="fas fa-user me-1"></i>
                        {{ $announcement->user->name }}
                    </span>
                @endif

                @if($announcement->city)
                    <span>
                        <i class="fas fa-map-marker-alt me-1"></i>
                        {{ $announcement->city }}
                    </span>
                @endif

                <span>
                    <i class="fas fa-calendar-alt me-1"></i>
                    {{ $announcement->created_at?->format('Y-m-d') }}
                </span>

            </div>

            <div class="mb-4" style="white-space: pre-line;">
                {{ $announcement->content }}
            </div>

            @if($announcement->phone)

                <div class="alert alert-light border mb-4">

                    <strong>
                        <i class="fas fa-phone me-1"></i>
                        رقم التواصل:
                    </strong>

                    <a
                        href="tel:{{ $announcement->phone }}"
                        class="text-decoration-none"
                    >
                        {{ $announcement->phone }}
                    </a>

                </div>

            @endif

            <div class="border-top pt-3 text-muted">

                <span class="me-4">
                    <i class="fas fa-heart me-1"></i>
                    {{ $announcement->likes_count ?? 0 }} إعجاب
                </span>

                <span>
                    <i class="fas fa-comments me-1"></i>
                    {{ $announcement->comments_count ?? 0 }} تعليق
                </span>

            </div>

        </div>

    </div>

</div>
@endsection
