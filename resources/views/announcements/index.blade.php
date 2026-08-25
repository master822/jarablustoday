@extends('layouts.app')

@section('title', 'الإعلانات')

@section('content')
<div class="container py-5" dir="rtl">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">الإعلانات</h1>
        <p class="text-muted">
            تصفح أحدث الإعلانات المنشورة على جرابلس اليوم
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- البحث --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <form method="GET" action="{{ route('announcements.index') }}">

                <div class="input-group">

                    <input
                        type="text"
                        name="q"
                        class="form-control"
                        value="{{ request('q') }}"
                        placeholder="ابحث في الإعلانات أو المدينة..."
                    >

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>
                        بحث
                    </button>

                </div>

            </form>

        </div>
    </div>

    @if($announcements->count())

        <div class="row g-4">

            @foreach($announcements as $announcement)

                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card h-100 border-0 shadow-sm overflow-hidden">

                        {{-- صورة الإعلان --}}
                        @if($announcement->image)

                            <img
                                src="{{ asset('storage/' . $announcement->image) }}"
                                alt="{{ $announcement->title }}"
                                class="card-img-top"
                                style="height:220px; object-fit:cover;"
                            >

                        @else

                            <div
                                class="d-flex align-items-center justify-content-center bg-light"
                                style="height:220px;"
                            >
                                <i class="fas fa-bullhorn fa-4x text-muted"></i>
                            </div>

                        @endif

                        <div class="card-body d-flex flex-column">

                            <h2 class="h5 fw-bold mb-3">
                                {{ $announcement->title }}
                            </h2>

                            <p class="text-muted mb-3">
                                {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content), 150) }}
                            </p>

                            @if($announcement->city)

                                <div class="small text-muted mb-2">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $announcement->city }}
                                </div>

                            @endif

                            @if($announcement->user)

                                <div class="small text-muted mb-3">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $announcement->user->name }}
                                </div>

                            @endif

                            <div class="small text-muted mb-3">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $announcement->created_at?->format('Y-m-d') }}
                            </div>

                            <div class="small text-muted mb-3">

                                <span class="me-3">
                                    <i class="fas fa-heart me-1"></i>
                                    {{ $announcement->likes_count ?? 0 }}
                                </span>

                                <span>
                                    <i class="fas fa-comments me-1"></i>
                                    {{ $announcement->comments_count ?? 0 }}
                                </span>

                            </div>

                            <div class="mt-auto">

                                <a
                                    href="{{ route('announcements.show', $announcement->id) }}"
                                    class="btn btn-rizk-primary w-100"
                                >
                                    عرض الإعلان
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $announcements->links() }}
        </div>

    @else

        <div class="text-center py-5">

            <i class="fas fa-bullhorn fa-4x text-muted mb-4"></i>

            <h3 class="fw-bold">
                لا توجد إعلانات حالياً
            </h3>

            <p class="text-muted">
                سيتم عرض الإعلانات المعتمدة هنا.
            </p>

        </div>

    @endif

</div>
@endsection
