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

            {{-- التفاعل والتعليقات --}}
            <div class="card border-0 shadow-sm mt-4" dir="rtl">
                <div class="card-body">

                    <div class="d-flex flex-wrap gap-2 align-items-center">

                        @auth
                            <form method="POST" action="{{ route('content.like') }}">
                                @csrf
                                <input type="hidden" name="type" value="news">
                                <input type="hidden" name="id" value="{{ $news->id }}">

                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-heart me-1"></i>
                                    إعجاب
                                    <span class="ms-1">{{ $news->likes_count ?? 0 }}</span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-danger">
                                <i class="fas fa-heart me-1"></i>
                                إعجاب
                                <span class="ms-1">{{ $news->likes_count ?? 0 }}</span>
                            </a>
                        @endauth

                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            onclick="toggleComments('news-comments')"
                        >
                            <i class="fas fa-comments me-1"></i>
                            التعليقات
                            <span class="ms-1">{{ $news->comments_count ?? 0 }}</span>
                        </button>

                    </div>

                    <div id="news-comments" class="mt-4" style="display:none;">

                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-comments me-1"></i>
                            التعليقات
                        </h5>

                        @if($news->comments->count())

                            <div class="vstack gap-3 mb-4">

                                @foreach($news->comments as $comment)

                                    <div class="border rounded p-3 bg-light">

                                        <div class="d-flex justify-content-between align-items-center mb-2">

                                            <strong>
                                                <i class="fas fa-user me-1"></i>
                                                {{ $comment->user->name ?? 'مستخدم' }}
                                            </strong>

                                            <small class="text-muted">
                                                {{ $comment->created_at?->format('Y-m-d H:i') }}
                                            </small>

                                        </div>

                                        <div>
                                            {{ $comment->comment }}
                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="alert alert-light border">
                                لا توجد تعليقات حتى الآن. كن أول من يعلق.
                            </div>

                        @endif

                        @auth

                            <form method="POST" action="{{ route('content.comment') }}">

                                @csrf

                                <input type="hidden" name="type" value="news">
                                <input type="hidden" name="id" value="{{ $news->id }}">

                                <div class="mb-3">

                                    <label class="form-label fw-bold">
                                        أضف تعليقك
                                    </label>

                                    <textarea
                                        name="content"
                                        class="form-control"
                                        rows="4"
                                        minlength="2"
                                        maxlength="1000"
                                        required
                                        placeholder="اكتب تعليقك هنا..."
                                    ></textarea>

                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-1"></i>
                                    نشر التعليق
                                </button>

                            </form>

                        @else

                            <div class="alert alert-warning">
                                يجب تسجيل الدخول حتى تتمكن من إضافة تعليق.
                                <a href="{{ route('login') }}" class="fw-bold">
                                    تسجيل الدخول
                                </a>
                            </div>

                        @endauth

                    </div>

                </div>
            </div>


            <div class="mt-4">
                <a href="{{ route('news.index') }}" class="btn btn-rizk-outline">
                    <i class="fas fa-arrow-right me-1"></i>
                    العودة إلى الأخبار
                </a>
            </div>

        </div>
    </div>

</div>

<script>
function toggleComments(id) {
    const element = document.getElementById(id);

    if (!element) {
        return;
    }

    element.style.display =
        element.style.display === 'none' ? 'block' : 'none';
}
</script>

@endsection

