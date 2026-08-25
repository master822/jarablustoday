@extends('layouts.app')

@section('title', $property->title)

@section('content')
<div class="container py-4" dir="rtl">

    <div class="mb-3">

        <a
            href="{{ $property->type === 'sale'
                ? route('properties.sale')
                : route('properties.rent') }}"
            class="btn btn-outline-secondary">
            ← العودة إلى العقارات
        </a>

    </div>

    <div class="card shadow-sm">

        {{-- الصور --}}
        @if(!empty($property->images) && is_array($property->images))

            <div class="row g-0">

                @foreach($property->images as $image)

                    <div class="col-md-6">

                        <img
                            src="{{ asset('storage/' . $image) }}"
                            class="img-fluid w-100"
                            style="height:350px; object-fit:cover;"
                            alt="{{ $property->title }}">

                    </div>

                @endforeach

            </div>

        @else

            <div
                class="d-flex align-items-center justify-content-center bg-light"
                style="height:300px; font-size:80px;">
                🏠
            </div>

        @endif

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">

                <div>

                    <h1 class="mb-2">
                        {{ $property->title }}
                    </h1>

                    @if($property->type === 'sale')
                        <span class="badge bg-success">
                            🏷️ للبيع
                        </span>
                    @else
                        <span class="badge bg-info text-dark">
                            🔑 للإيجار
                        </span>
                    @endif

                </div>

                <div class="text-primary fs-3 fw-bold">
                    ${{ number_format((float) $property->price, 2) }}
                </div>

            </div>

            <hr>

            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <div class="border rounded p-3">
                        📍 <strong>المدينة:</strong>
                        {{ $property->city }}
                    </div>
                </div>

                @if($property->address)
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            📍 <strong>الموقع:</strong>
                            {{ $property->address }}
                        </div>
                    </div>
                @endif

                <div class="col-md-6">
                    <div class="border rounded p-3">
                        📐 <strong>المساحة:</strong>
                        {{ $property->area_m2 }} م²
                    </div>
                </div>

                @if($property->building_age !== null)
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            🏗️ <strong>عمر البناء:</strong>
                            {{ $property->building_age }} سنة
                        </div>
                    </div>
                @endif

                @if($property->finishing_type)
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            🎨 <strong>نوع الإكساء:</strong>
                            {{ $property->finishing_type }}
                        </div>
                    </div>
                @endif

                @if($property->rooms !== null)
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            🛏️ <strong>عدد الغرف:</strong>
                            {{ $property->rooms }}
                        </div>
                    </div>
                @endif

                @if($property->bathrooms !== null)
                    <div class="col-md-6">
                        <div class="border rounded p-3">
                            🚿 <strong>عدد الحمامات:</strong>
                            {{ $property->bathrooms }}
                        </div>
                    </div>
                @endif

                <div class="col-md-6">
                    <div class="border rounded p-3">
                        💵 <strong>العملة:</strong>
                        الدولار الأمريكي (USD)
                    </div>
                </div>

            </div>

            <h4 class="mb-3">
                📝 وصف العقار
            </h4>

            <div class="border rounded p-3 mb-4">
                {!! nl2br(e($property->description)) !!}
            </div>

            {{-- الإعجاب والتعليقات --}}
            <div class="card border-0 shadow-sm mb-4">

                <div class="card-body">

                    <div class="d-flex flex-wrap gap-2 align-items-center">

                        @auth

                            <form method="POST" action="{{ route('content.like') }}">
                                @csrf

                                <input
                                    type="hidden"
                                    name="type"
                                    value="property"
                                >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="{{ $property->id }}"
                                >

                                <button
                                    type="submit"
                                    class="btn btn-outline-danger"
                                >
                                    <i class="fas fa-heart me-1"></i>
                                    إعجاب
                                    <span class="ms-1">
                                        {{ $property->likes_count ?? 0 }}
                                    </span>
                                </button>

                            </form>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="btn btn-outline-danger"
                            >
                                <i class="fas fa-heart me-1"></i>
                                إعجاب
                                <span class="ms-1">
                                    {{ $property->likes_count ?? 0 }}
                                </span>
                            </a>

                        @endauth

                        <button
                            type="button"
                            class="btn btn-outline-primary"
                            onclick="toggleComments('property-comments')"
                        >
                            <i class="fas fa-comments me-1"></i>
                            التعليقات

                            <span class="ms-1">
                                {{ $property->comments_count ?? 0 }}
                            </span>
                        </button>

                    </div>


                    {{-- منطقة التعليقات --}}
                    <div
                        id="property-comments"
                        class="mt-4"
                        style="display:none;"
                    >

                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-comments me-1"></i>
                            التعليقات
                        </h5>


                        @if($property->comments->count())

                            <div class="vstack gap-3 mb-4">

                                @foreach($property->comments as $comment)

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


                        {{-- إضافة تعليق --}}
                        @auth

                            <form
                                method="POST"
                                action="{{ route('content.comment') }}"
                            >

                                @csrf

                                <input
                                    type="hidden"
                                    name="type"
                                    value="property"
                                >

                                <input
                                    type="hidden"
                                    name="id"
                                    value="{{ $property->id }}"
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

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
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


            <div class="border rounded p-3 mb-4">

                <h5>
                    👤 صاحب العقار
                </h5>

                <div>
                    {{ $property->user->name ?? 'مستخدم' }}
                </div>

            </div>

@auth
    @if($property->user_id !== auth()->id())
        <div class="border rounded p-4 mb-4 bg-light">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="mb-1">👤 صاحب العقار</h5>
                    <div>{{ $property->user->name ?? 'مستخدم' }}</div>
                </div>

                <a
                    href="{{ route('messages.conversation', $property->user_id) }}"
                    class="btn btn-primary">
                    <i class="fas fa-comments me-1"></i>
                    تواصل مع صاحب العقار
                </a>
            </div>
        </div>
    @endif
@else
    <div class="border rounded p-4 mb-4 bg-light text-center">
        <h5 class="mb-2">💬 هل تريد التواصل مع صاحب العقار؟</h5>
        <p class="text-muted mb-3">
            سجّل الدخول أولاً للتواصل مع صاحب العقار.
        </p>

        <a href="{{ route('login') }}" class="btn btn-primary">
            <i class="fas fa-sign-in-alt me-1"></i>
            تسجيل الدخول للتواصل
        </a>
    </div>
@endauth

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

