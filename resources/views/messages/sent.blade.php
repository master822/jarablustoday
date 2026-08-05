@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4 class="mb-0">الرسائل المرسلة</h4>
                </div>
                <div class="card-body p-0">
                    @if($messages->count() > 0)
                        @foreach($messages as $message)
                            <div class="d-flex align-items-center p-3 border-bottom">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">{{ $message->receiver->name ?? 'مستخدم غير معروف' }}</h6>
                                        <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 text-muted small">{{ Str::limit($message->content, 100) }}</p>
                                    <small class="text-muted">
                                        <i class="fas fa-check{{ $message->is_read ? '-double' : '' }}"></i>
                                        {{ $message->is_read ? 'مقروءة' : 'غير مقروءة' }}
                                    </small>
                                </div>
                                <a href="{{ route('messages.conversation', $message->receiver_id) }}" class="btn btn-sm ms-2" style="background: #d4af37; color: white;">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-center p-3">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-paper-plane fa-4x text-muted mb-3"></i>
                            <p class="text-muted">لا توجد رسائل مرسلة</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
