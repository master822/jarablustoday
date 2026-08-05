@extends('layouts.app')

@section('title', 'الرسائل')

@section('content')
<div class="container py-4">
    <h4 class="section-title-rizk">الرسائل</h4>
    <div class="card-rizk p-3">
        @forelse($messages as $message)
        <div class="border-bottom py-2 {{ !$message->is_read ? 'bg-gold-gradient bg-opacity-10' : '' }}">
            <div class="d-flex justify-content-between">
                <div>
                    <strong style="color: var(--text-primary);">{{ $message->sender->name ?? 'غير معروف' }}</strong>
                    <p style="color: var(--text-muted);">{{ $message->message }}</p>
                </div>
                <div>
                    <small style="color: var(--text-muted);">{{ $message->created_at->diffForHumans() }}</small>
                    @if(!$message->is_read)
                        <form action="{{ route('merchant.messages.read', $message->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-rizk-primary">تحديد كمقروء</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <p style="color: var(--text-muted);">لا توجد رسائل</p>
        @endforelse
    </div>
    {{ $messages->links() }}
</div>
@endsection
