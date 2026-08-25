@extends('layouts.app')

@section('title', 'إدارة الإعلانات')

@section('content')
<div class="container py-4" dir="rtl">
    <h1 class="mb-4">📢 إدارة الإعلانات</h1>

    @foreach($items as $item)
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $item->title }}</h4>
                <p>{{ $item->content }}</p>

                <small>
                    {{ $item->city }}
                    @if($item->phone)
                        — {{ $item->phone }}
                    @endif
                </small>

                <br>

                <span class="badge
                    @if($item->status === 'approved') bg-success
                    @elseif($item->status === 'rejected') bg-danger
                    @else bg-warning text-dark @endif">
                    {{ $item->status }}
                </span>

                <div class="mt-3">
                    @if($item->status !== 'approved')
                        <form method="POST"
                              action="{{ route('admin.announcements.approve', $item->id) }}"
                              class="d-inline">
                            @csrf
                            <button class="btn btn-success">
                                موافقة ونشر
                            </button>
                        </form>
                    @endif

@if($item->status !== 'rejected')
    <form method="POST"
          action="{{ route('admin.announcements.reject', $item->id) }}"
          class="mt-3">
        @csrf

        <div class="mb-2">
            <label class="form-label fw-bold">
                سبب الرفض
            </label>

            <textarea
                name="rejection_reason"
                class="form-control"
                rows="3"
                required
                placeholder="اكتب سبب رفض الإعلان..."
            ></textarea>
        </div>

        <button type="submit" class="btn btn-danger">
            <i class="fas fa-times me-1"></i>
            رفض الإعلان وإرسال السبب
        </button>
    </form>
@endif
                </div>
            </div>
        </div>
    @endforeach

    {{ $items->links() }}
</div>
@endsection
