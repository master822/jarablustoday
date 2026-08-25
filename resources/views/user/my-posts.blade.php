@extends('layouts.app')

@section('title', 'منشوراتي')

@section('content')
<div class="container py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h4 class="section-title-rizk mb-1">منشوراتي</h4>
            <p style="color: var(--text-muted); margin:0;">
                إدارة جميع الأخبار والإعلانات والعقارات والمنتجات الخاصة بك
            </p>
        </div>

        <a href="{{ route('user.dashboard') }}" class="btn btn-rizk-outline">
            <i class="fas fa-arrow-right"></i>
            العودة إلى لوحتي
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- Filters --}}
    <div class="card-rizk p-3 mb-4">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('user.posts') }}"
               class="btn {{ !$type ? 'btn-rizk-primary' : 'btn-rizk-outline' }}">
                الكل
            </a>

            <a href="{{ route('user.posts', ['type' => 'news']) }}"
               class="btn {{ $type === 'news' ? 'btn-rizk-primary' : 'btn-rizk-outline' }}">
                📰 أخباري
            </a>

            <a href="{{ route('user.posts', ['type' => 'announcement']) }}"
               class="btn {{ $type === 'announcement' ? 'btn-rizk-primary' : 'btn-rizk-outline' }}">
                📢 إعلاناتي
            </a>

            <a href="{{ route('user.posts', ['type' => 'property']) }}"
               class="btn {{ $type === 'property' ? 'btn-rizk-primary' : 'btn-rizk-outline' }}">
                🏠 عقاراتي
            </a>

            <a href="{{ route('user.posts', ['type' => 'product']) }}"
               class="btn {{ $type === 'product' ? 'btn-rizk-primary' : 'btn-rizk-outline' }}">
                🛍️ منتجاتي
            </a>
        </div>
    </div>

    <div class="card-rizk p-3">

        @forelse($posts as $post)

            @php
                $status = $post->post_status;

                $statusText = match($status) {
                    'approved' => 'منشور',
                    'active' => 'نشط',
                    'pending' => 'قيد المراجعة',
                    'rejected' => 'مرفوض',
                    default => $status ?: 'غير محدد',
                };

                $statusClass = match($status) {
                    'approved', 'active' => 'bg-success',
                    'pending' => 'bg-warning text-dark',
                    'rejected' => 'bg-danger',
                    default => 'bg-secondary',
                };

                $likes = $post->likes_count ?? $post->active_likes_count ?? 0;
                $comments = $post->comments_count ?? 0;
                $views = $post->views ?? null;
            @endphp

            <div class="border rounded p-3 mb-3">

                <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">

                    <div>
                        <div class="mb-1">
                            <span class="badge bg-secondary">
                                {{ $post->post_type_label }}
                            </span>

                            <span class="badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </div>

                        <h5 class="mb-1">
                            {{ $post->post_title }}
                        </h5>

                        <small style="color:var(--text-muted);">
                            {{ $post->created_at?->format('Y-m-d H:i') }}
                        </small>
                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        <a href="{{ $post->post_url }}"
                           class="btn btn-sm btn-rizk-outline">
                            <i class="fas fa-eye"></i>
                            عرض
                        </a>

                        @if($post->post_type === 'product')
                            <a href="{{ route('user.products.edit', $post->id) }}"
                               class="btn btn-sm btn-rizk-outline">
                                <i class="fas fa-edit"></i>
                                تعديل
                            </a>
                        @else
                            <a href="{{ route('user.posts.edit', [$post->post_type, $post->id]) }}"
                               class="btn btn-sm btn-rizk-outline">
                                <i class="fas fa-edit"></i>
                                تعديل
                            </a>
                        @endif

                        <form action="{{ route('user.posts.delete', [$post->post_type, $post->id]) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المنشور؟ لا يمكن التراجع عن هذه العملية.');">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                                حذف
                            </button>
                        </form>

                    </div>
                </div>

                <div class="row mt-3 g-2">

                    <div class="col-6 col-md-3">
                        <div class="p-2 border rounded text-center">
                            <div style="font-size:20px;">❤️</div>
                            <strong>{{ $likes }}</strong>
                            <small class="d-block text-muted">الإعجابات</small>
                        </div>
                    </div>

                    @if($post->post_type !== 'product')
                        <div class="col-6 col-md-3">
                            <div class="p-2 border rounded text-center">
                                <div style="font-size:20px;">💬</div>
                                <strong>{{ $comments }}</strong>
                                <small class="d-block text-muted">التعليقات</small>
                            </div>
                        </div>
                    @endif

                    @if($views !== null)
                        <div class="col-6 col-md-3">
                            <div class="p-2 border rounded text-center">
                                <div style="font-size:20px;">👁️</div>
                                <strong>{{ $views }}</strong>
                                <small class="d-block text-muted">المشاهدات</small>
                            </div>
                        </div>
                    @endif

                    @if($status === 'rejected' && !empty($post->rejection_reason))
                        <div class="col-12">
                            <div class="alert alert-danger mb-0 mt-2">
                                <strong>سبب الرفض:</strong>
                                {{ $post->rejection_reason }}
                            </div>
                        </div>
                    @endif

                </div>

            </div>

        @empty

            <div class="text-center py-5">
                <div style="font-size:55px;">📂</div>

                <h5 class="mt-3">لا توجد منشورات</h5>

                <p style="color:var(--text-muted);">
                    لم تقم بإضافة أي منشورات بعد.
                </p>

                <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
                    <a href="{{ route('news.create') }}"
                       class="btn btn-rizk-outline">
                        + إضافة خبر
                    </a>

                    <a href="{{ route('announcements.create') }}"
                       class="btn btn-rizk-outline">
                        + إضافة إعلان
                    </a>

                    <a href="{{ route('properties.create') }}"
                       class="btn btn-rizk-outline">
                        + إضافة عقار
                    </a>

                    <a href="{{ route('user.products.create') }}"
                       class="btn btn-rizk-primary">
                        + إضافة منتج
                    </a>
                </div>
            </div>

        @endforelse

        @if($posts->hasPages())
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
