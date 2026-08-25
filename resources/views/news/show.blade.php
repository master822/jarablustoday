@extends('layouts.app')

@section('title', $news->title)

@section('content')
<div class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-9">

            <article class="card border-0 shadow-sm overflow-hidden">

                @if($news->image)
                    <img
                        src="{{ asset('storage/' . $news->image) }}"
                        alt="{{ $news->title }}"
                        class="card-img-top"
                        style="max-height:500px; object-fit:cover;"
                    >
                @endif

                <div class="card-body p-4 p-lg-5">

                    <h1 class="fw-bold mb-3">
                        {{ $news->title }}
                    </h1>

                    <div class="text-muted small mb-4">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ $news->created_at?->format('Y-m-d') }}

                        @if($news->user)
                            <span class="mx-2">•</span>
                            <i class="fas fa-user me-1"></i>
                            {{ $news->user->name }}
                        @endif
                    </div>

                    @if($news->excerpt)
                        <div class="alert alert-light border mb-4">
                            {{ $news->excerpt }}
                        </div>
                    @endif

                    <div class="news-content">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                </div>

            </article>

            <div class="mt-4">
                <a href="{{ route('news.index') }}" class="btn btn-rizk-outline">
                    <i class="fas fa-arrow-right me-1"></i>
                    العودة إلى الأخبار
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
