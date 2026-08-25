@extends('layouts.app')

@section('title', 'إدارة التعليقات')

@section('content')
<div class="container py-4" dir="rtl">

    <h1 class="mb-4">💬 إدارة التعليقات</h1>

    @forelse($comments as $comment)

        <div class="card mb-3">
            <div class="card-body">

                <div class="d-flex justify-content-between">
                    <strong>
                        {{ $comment->user->name ?? 'مستخدم' }}
                    </strong>

                    <span class="badge
                        {{ $comment->status === 'approved'
                            ? 'bg-success'
                            : ($comment->status === 'rejected'
                                ? 'bg-danger'
                                : 'bg-warning text-dark') }}">
                        {{ $comment->status }}
                    </span>
                </div>

                <p class="mt-3 mb-2">
                    {{ $comment->comment }}
                </p>

                @if($comment->moderation_reason)
                    <div class="alert alert-danger py-2">
                        <strong>سبب الرفض:</strong>
                        {{ $comment->moderation_reason }}
                    </div>
                @endif

                <small class="text-muted">
                    {{ $comment->created_at->diffForHumans() }}
                </small>

                <div class="mt-3">

                    @if($comment->status !== 'approved')
                        <form method="POST"
                              action="{{ route('admin.comments.approve', $comment->id) }}"
                              class="d-inline">
                            @csrf

                            <button class="btn btn-success btn-sm">
                                <i class="fas fa-check"></i>
                                موافقة
                            </button>
                        </form>
                    @endif

                    @if($comment->status !== 'rejected')
                        <form method="POST"
                              action="{{ route('admin.comments.reject', $comment->id) }}"
                              class="d-inline">

                            @csrf

                            <button class="btn btn-danger btn-sm">
                                <i class="fas fa-times"></i>
                                رفض
                            </button>
                        </form>
                    @endif

                </div>

            </div>
        </div>

    @empty

        <div class="alert alert-info">
            لا توجد تعليقات.
        </div>

    @endforelse

    {{ $comments->links() }}

</div>
@endsection
