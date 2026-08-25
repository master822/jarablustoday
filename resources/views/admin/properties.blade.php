@extends('layouts.app')

@section('title', 'إدارة العقارات')

@section('content')
<div class="container py-4" dir="rtl">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">🏠 إدارة العقارات</h1>
            <p class="text-muted mb-0">
                العقارات التي تنتظر المراجعة والموافقة
            </p>
        </div>

        <span class="badge bg-warning text-dark fs-6">
            قيد المراجعة: {{ $items->total() }}
        </span>
    </div>

    @if($items->count() === 0)

        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">

                <i class="fas fa-house-circle-check fa-3x text-muted mb-3"></i>

                <h4>لا توجد عقارات بانتظار المراجعة</h4>

                <p class="text-muted mb-0">
                    جميع العقارات تمت مراجعتها.
                </p>

            </div>
        </div>

    @else

        @foreach($items as $item)

            <div class="card mb-4 shadow-sm border-0 overflow-hidden">

                <div class="card-body">

                    <div class="row g-4">

                        {{-- الصور --}}
                        <div class="col-12 col-md-4">

                            @php
                                $images = is_array($item->images)
                                    ? $item->images
                                    : [];

                                $firstImage = $images[0] ?? null;
                            @endphp

                            @if($firstImage)

                                <img
                                    src="{{ asset('storage/' . ltrim($firstImage, '/')) }}"
                                    alt="{{ $item->title }}"
                                    class="img-fluid rounded"
                                    style="width:100%; height:240px; object-fit:cover;"
                                    onerror="this.style.display='none';"
                                >

                            @else

                                <div
                                    class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="height:240px;"
                                >
                                    <div class="text-center text-muted">
                                        <i class="fas fa-house fa-3x mb-2"></i>
                                        <div>لا توجد صورة</div>
                                    </div>
                                </div>

                            @endif

                        </div>

                        {{-- المعلومات --}}
                        <div class="col-12 col-md-8">

                            <div class="d-flex flex-wrap gap-2 align-items-center mb-2">

                                <h3 class="mb-0">
                                    {{ $item->title }}
                                </h3>

                                <span class="badge bg-info">
                                    {{ $item->type === 'sale' ? 'للبيع' : 'للإيجار' }}
                                </span>

                                <span class="badge bg-warning text-dark">
                                    بانتظار المراجعة
                                </span>

                            </div>

                            <p class="text-muted mb-3">
                                {{ $item->description }}
                            </p>

                            <div class="row g-2 mb-3">

                                <div class="col-6 col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            السعر
                                        </small>
                                        <strong>
                                            {{ number_format($item->price, 2) }}
                                            {{ $item->currency }}
                                        </strong>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            المدينة
                                        </small>
                                        <strong>
                                            {{ $item->city ?: 'غير محدد' }}
                                        </strong>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            المساحة
                                        </small>
                                        <strong>
                                            {{ $item->area_m2 ?: $item->area ?: 'غير محدد' }}
                                            @if($item->area_m2)
                                                م²
                                            @endif
                                        </strong>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            الغرف
                                        </small>
                                        <strong>
                                            {{ $item->rooms ?: 'غير محدد' }}
                                        </strong>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            الحمامات
                                        </small>
                                        <strong>
                                            {{ $item->bathrooms ?: 'غير محدد' }}
                                        </strong>
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            عمر البناء
                                        </small>
                                        <strong>
                                            {{ $item->building_age ?: 'غير محدد' }}
                                        </strong>
                                    </div>
                                </div>

                            </div>

                            <div class="mb-3">

                                <strong>
                                    <i class="fas fa-location-dot me-1"></i>
                                    العنوان:
                                </strong>

                                {{ $item->address ?: 'غير محدد' }}

                            </div>

                            @if($item->user)

                                <div class="mb-3">

                                    <strong>
                                        <i class="fas fa-user me-1"></i>
                                        صاحب العقار:
                                    </strong>

                                    {{ $item->user->name ?? $item->user->username ?? 'غير معروف' }}

                                </div>

                            @endif

                            {{-- أزرار الإدارة --}}
                            <div class="border-top pt-3">

                                <div class="d-flex flex-column flex-md-row gap-2">

                                    {{-- الموافقة --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.properties.approve', $item->id) }}"
                                        class="flex-grow-1"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-success w-100"
                                            onclick="return confirm('هل أنت متأكد من الموافقة على نشر هذا العقار؟')"
                                        >
                                            <i class="fas fa-check me-1"></i>
                                            موافقة ونشر
                                        </button>

                                    </form>

                                    {{-- الرفض --}}
                                    <form
                                        method="POST"
                                        action="{{ route('admin.properties.reject', $item->id) }}"
                                        class="flex-grow-1"
                                    >

                                        @csrf

                                        <textarea
                                            name="rejection_reason"
                                            class="form-control mb-2"
                                            rows="2"
                                            required
                                            placeholder="سبب رفض العقار..."
                                        ></textarea>

                                        <button
                                            type="submit"
                                            class="btn btn-danger w-100"
                                            onclick="return confirm('هل أنت متأكد من رفض هذا العقار؟')"
                                        >
                                            <i class="fas fa-times me-1"></i>
                                            رفض العقار
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

        <div class="mt-4">
            {{ $items->links() }}
        </div>

    @endif

</div>
@endsection
