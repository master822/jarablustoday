@extends('layouts.app')

@section('content')

<div class="container py-4" dir="rtl">
    <div class="row justify-content-center">
        <div class="col-md-8">

```
        <div class="card shadow-sm">

            {{-- رأس المحادثة --}}
            <div class="card-header" style="background: #d4af37; color: white;">
                <div class="d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center">
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($otherUser->name) }}&size=40&background=d4af37&color=fff"
                            class="rounded-circle me-2"
                            width="40"
                            height="40"
                            alt="{{ $otherUser->name }}"
                        >

                        <h5 class="mb-0">
                            {{ $otherUser->name }}
                        </h5>
                    </div>

                    <div class="d-flex align-items-center gap-2">

                        {{-- رجوع إلى الرسائل --}}
                        <a
                            href="{{ route('messages.inbox') }}"
                            class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-right me-1"></i>
                            رجوع
                        </a>

                        {{-- مسح المحادثة بالكامل --}}
                        <form
                            action="{{ route('messages.clear-conversation', $otherUser->id) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('هل أنت متأكد من مسح المحادثة بالكامل؟');"
                        >
                            @csrf

                            {{-- مهم: لا نستخدم @method('DELETE')
                                 لأن Route الخاص بمسح المحادثة يستقبل POST --}}

                            <button
                                type="submit"
                                class="btn btn-sm btn-danger"
                                title="مسح المحادثة">
                                <i class="fas fa-trash"></i>
                                <span class="d-none d-sm-inline ms-1">مسح المحادثة</span>
                            </button>
                        </form>

                    </div>
                </div>
            </div>


            {{-- الرسائل --}}
            <div
                class="card-body"
                style="max-height: 450px; overflow-y: auto; background: #f8f9fa;"
            >

                @if($messages->count() > 0)

                    @foreach($messages as $message)

                        <div class="mb-3 {{ $message->sender_id == Auth::id() ? 'text-end' : '' }}">

                            <div
                                class="d-inline-block p-3 rounded shadow-sm {{ $message->sender_id == Auth::id() ? 'text-white' : 'bg-white' }}"
                                style="
                                    max-width: 75%;
                                    word-break: break-word;
                                    {{ $message->sender_id == Auth::id()
                                        ? 'background: #d4af37 !important;'
                                        : ''
                                    }}
                                "
                            >

                                <p class="mb-1">
                                    {{ $message->message ?? $message->content }}
                                </p>

                                <small
                                    class="{{ $message->sender_id == Auth::id()
                                        ? 'text-white-50'
                                        : 'text-muted'
                                    }}"
                                >
                                    {{ $message->created_at->diffForHumans() }}

                                    @if($message->sender_id == Auth::id() && $message->is_read)
                                        <i
                                            class="fas fa-check-double ms-1"
                                            title="تمت القراءة"
                                        ></i>
                                    @endif
                                </small>

                            </div>


                            {{-- حذف الرسالة الفردية --}}
                            @if($message->sender_id == Auth::id())

                                <form
                                    action="{{ route('messages.delete', $message->id) }}"
                                    method="POST"
                                    style="display: inline;"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-sm btn-link text-danger"
                                        title="حذف الرسالة"
                                        onclick="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')"
                                    >
                                        <i class="fas fa-times"></i>
                                    </button>

                                </form>

                            @endif

                        </div>

                    @endforeach

                @else

                    <div class="text-center text-muted py-5">

                        <i class="fas fa-comment-dots fa-3x mb-3"></i>

                        <p class="mb-0">
                            لا توجد رسائل بعد
                        </p>

                    </div>

                @endif

            </div>


            {{-- إرسال رسالة --}}
            <div class="card-footer bg-white">

                <form
                    method="POST"
                    action="{{ route('messages.send-conversation', $otherUser->id) }}"
                >

                    @csrf

                    <div class="input-group">

                        <input
                            type="text"
                            class="form-control"
                            name="message"
                            placeholder="اكتب رسالتك..."
                            maxlength="1000"
                            autocomplete="off"
                            required
                        >

                        <button
                            type="submit"
                            class="btn"
                            style="background: #d4af37; color: white;"
                        >
                            <i class="fas fa-paper-plane me-1"></i>
                            إرسال
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>
</div>
```

</div>
@endsection
