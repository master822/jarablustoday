@extends('layouts.app')

@section('title', 'الإشعارات')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title-rizk">الإشعارات</h4>
        <div class="d-flex gap-2">
            @if($unreadCount > 0)
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-rizk-primary btn-sm">
                        <i class="fas fa-check-double me-1"></i>تحديد الكل كمقروء
                    </button>
                </form>
            @endif
            <form action="{{ route('notifications.delete-all') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف جميع الإشعارات؟')">
                    <i class="fas fa-trash me-1"></i>حذف الكل
                </button>
            </form>
        </div>
    </div>
    
    <div class="card-rizk p-3">
        @forelse($notifications as $notification)
            <div class="notification-item border-bottom py-3 {{ !$notification->is_read ? 'bg-gold-gradient bg-opacity-10' : '' }}">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex gap-3">
                        <div class="notification-icon mt-1">
                            @if($notification->type == 'message')
                                <i class="fas fa-envelope text-primary"></i>
                            @elseif($notification->type == 'rating')
                                <i class="fas fa-star text-warning"></i>
                            @elseif($notification->type == 'order')
                                <i class="fas fa-shopping-cart text-success"></i>
                            @else
                                <i class="fas fa-bell text-info"></i>
                            @endif
                        </div>
                        <div>
                            <h6 style="color: var(--text-primary); margin: 0;">
                                {{ $notification->title }}
                                @if(!$notification->is_read)
                                    <span class="badge bg-primary ms-2" style="font-size: 0.6rem;">جديد</span>
                                @endif
                            </h6>
                            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">
                                {{ $notification->message }}
                            </p>
                            <small style="color: var(--text-muted);">
                                {{ $notification->created_at->diffForHumans() }}
                                @if($notification->sender)
                                    • من: {{ $notification->sender->name }}
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="d-flex gap-1">
                        @if(!$notification->is_read)
                            <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-rizk-outline btn-sm" title="تحديد كمقروء">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        @endif
                        @if($notification->link)
                            <a href="{{ $notification->link }}" class="btn btn-rizk-primary btn-sm" title="عرض">
                                <i class="fas fa-eye"></i>
                            </a>
                        @endif
                        <form action="{{ route('notifications.delete', $notification->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')" title="حذف">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-3x gold-text mb-3"></i>
                <p style="color: var(--text-muted);">لا توجد إشعارات</p>
            </div>
        @endforelse
    </div>
    
    {{ $notifications->links() }}
</div>
@endsection
