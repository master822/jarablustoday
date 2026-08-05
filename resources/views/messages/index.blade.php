@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4 class="mb-0">المحادثات</h4>
                </div>
                <div class="card-body p-0">
                    @if($conversations->count() > 0)
                        @foreach($conversations as $conversation)
                            <a href="{{ route('messages.conversation', $conversation['user']->id) }}" 
                               class="text-decoration-none text-dark">
                                <div class="d-flex align-items-center p-3 border-bottom hover-bg-light" 
                                     style="transition: background 0.2s; cursor: pointer;">
                                    <div class="flex-shrink-0">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($conversation['user']->name) }}&size=50&background=d4af37&color=fff" 
                                             class="rounded-circle" width="50" height="50">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0 fw-bold">{{ $conversation['user']->name }}</h6>
                                            <small class="text-muted">{{ $conversation['last_message']->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <p class="mb-0 text-muted small">
                                                {{ Str::limit($conversation['last_message']->content, 50) }}
                                            </p>
                                            @if($conversation['unread_count'] > 0)
                                                <span class="badge" style="background: #d4af37; color: white; border-radius: 50%;">
                                                    {{ $conversation['unread_count'] }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comment-dots fa-4x text-muted mb-3"></i>
                            <p class="text-muted">لا توجد محادثات بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
</style>
@endpush
