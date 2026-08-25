@extends('layouts.app')

@section('title', 'إدارة الأخبار')

@section('content')
<div class="container py-4" dir="rtl">
    <h1 class="mb-4">📰 إدارة الأخبار</h1>

    @foreach($items as $item)
        <div class="card mb-3">
            <div class="card-body">
                <h4>{{ $item->title }}</h4>
                <p>{{ $item->content }}</p>

                <span class="badge
                    @if($item->status === 'approved') bg-success
                    @elseif($item->status === 'rejected') bg-danger
                    @else bg-warning text-dark @endif">
                    {{ $item->status }}
                </span>

                <div class="mt-3">
                    @if($item->status !== 'approved')
                        <form method="POST"
                              action="{{ route('admin.news.approve', $item->id) }}"
                              class="d-inline">
                            @csrf
                            <button class="btn btn-success">
                                موافقة ونشر
                            </button>
                        </form>
                    @endif

@if($item->status !== 'rejected')
    <form method="POST"
          action="{{ route('admin.news.reject', $item->id) }}"
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
                placeholder="اكتب سبب رفض الخبر..."
            ></textarea>
        </div>

        <button type="submit" class="btn btn-danger">
            <i class="fas fa-times me-1"></i>
            رفض الخبر وإرسال السبب
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
