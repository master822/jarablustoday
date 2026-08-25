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


            {{-- التفاعل والتعليقات --}}
            <div class="card border-0 shadow-sm mt-4">

                <div class="card-body">

                    <div class="d-flex flex-wrap gap-2 align-items-center">

                        @auth
                            <form method="POST" action="{{ route('content.like') }}">
                                @csrf

                                <input type="hidden" name="type" value="announcement">
                                <input type="hidden" name="id" value="{{ $announcement->id }}">

                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-heart me-1"></i>
                                    إعجاب
                                    <span class="ms-1">
                                        {{ $announcement->likes_count ?? 0 }}
                                    </span>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-danger">
                                <i class="fas fa-heart me-1"></i>
                                إعجاب
                                <span class="ms-1">
                                    {{ $announcement->likes_count ?? 0 }}
                                </span>
                            </a>
                        @endauth

                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            onclick="toggleComments('announcement-comments')"
                        >
                            <i class="fas fa-comments me-1"></i>
                            التعليقات
                            <span class="ms-1">
                                {{ $announcement->comments_count ?? 0 }}
                            </span>
                        </button>

                    </div>

                    <div
                        id="announcement-comments"
                        class="mt-4"
                        style="display:none;"
                    >

                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-comments me-1"></i>
                            التعليقات
                        </h5>

                        @if($announcement->comments->count())

                            <div class="vstack gap-3 mb-4">

                                @foreach($announcement->comments as $comment)

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

                                <input
                                    type="hidden"
                                    name="type"
                                    value="announcement"
                                >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="{{ $announcement->id }}"
                                >

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

                                <a
                                    href="{{ route('login') }}"
                                    class="fw-bold"
                                >
                                    تسجيل الدخول
                                </a>

                            </div>

                        @endauth

                    </div>

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

