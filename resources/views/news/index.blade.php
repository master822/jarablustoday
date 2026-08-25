@extends('layouts.app')

@section('title', 'آخر الأخبار')

@section('content')
<div class="container py-5">

    <div class="text-center mb-5">
        <h1 class="fw-bold mb-2">آخر الأخبار</h1>
        <p class="text-muted">تابع أحدث الأخبار والتحديثات على جرابلس اليوم</p>
    </div>

    @if($news->count())

        <div class="row g-4">

            @foreach($news as $item)

                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card h-100 border-0 shadow-sm overflow-hidden">

                        @if($item->image)
                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->title }}"
                                class="card-img-top"
                                style="height:220px; object-fit:cover;"
                            >
                        @endif

                        <div class="card-body d-flex flex-column">

                            <h2 class="h5 fw-bold mb-3">
                                {{ $item->title }}
                            </h2>

                            @if($item->excerpt)
                                <p class="text-muted mb-3">
                                    {{ $item->excerpt }}
                                </p>
                            @elseif($item->content)
                                <p class="text-muted mb-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($item->content), 150) }}
                                </p>
                            @endif

                            <div class="mt-auto">

                                <div class="small text-muted mb-3">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ $item->created_at?->format('Y-m-d') }}
                                </div>

                                <a
                                    href="{{ route('news.show', $item->id) }}"
                                    class="btn btn-rizk-primary w-100"
                                >
                                    اقرأ المزيد
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $news->links() }}
        </div>

    @else

        <div class="text-center py-5">

            <i class="fas fa-newspaper fa-4x text-muted mb-4"></i>

            <h3 class="fw-bold">
                لا توجد أخبار حالياً
            </h3>

            <p class="text-muted">
                سيتم عرض الأخبار الجديدة هنا.
            </p>

        </div>

    @endif

</div>
@endsection
