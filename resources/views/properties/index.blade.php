@extends('layouts.app')

@section('title', $type === 'sale' ? 'عقارات للبيع' : 'عقارات للإيجار')

@section('content')
<div class="container py-4" dir="rtl">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">

        <div>
            <h2 class="mb-1">
                {{ $type === 'sale' ? '🏠 عقارات للبيع' : '🔑 عقارات للإيجار' }}
            </h2>

            <p class="text-muted mb-0">
                {{ $type === 'sale'
                    ? 'تصفح العقارات المعروضة للبيع'
                    : 'تصفح العقارات المعروضة للإيجار' }}
            </p>
        </div>

        @auth
            <a href="{{ route('properties.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                إضافة عقار
            </a>
        @endauth

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- البحث والفلاتر --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <form method="GET" action="{{ $type === 'sale'
                ? route('properties.sale')
                : route('properties.rent') }}">

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">بحث</label>
                        <input
                            type="text"
                            name="q"
                            class="form-control"
                            value="{{ request('q') }}"
                            placeholder="ابحث عن عقار أو مدينة...">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">المدينة</label>
                        <input
                            type="text"
                            name="city"
                            class="form-control"
                            value="{{ request('city') }}"
                            placeholder="مثال: جرابلس">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">أقل سعر $</label>
                        <input
                            type="number"
                            name="min_price"
                            class="form-control"
                            min="0"
                            value="{{ request('min_price') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">أعلى سعر $</label>
                        <input
                            type="number"
                            name="max_price"
                            class="form-control"
                            min="0"
                            value="{{ request('max_price') }}">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            🔎
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    @if($properties->count())

        <div class="row g-4">

            @foreach($properties as $property)

                <div class="col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm">

                        {{-- الصورة --}}
                        @if(!empty($property->images) && is_array($property->images))

                            <img
                                src="{{ asset('storage/' . $property->images[0]) }}"
                                class="card-img-top"
                                style="height:220px; object-fit:cover;"
                                alt="{{ $property->title }}">

                        @else

                            <div
                                class="d-flex align-items-center justify-content-center bg-light"
                                style="height:220px; font-size:60px;">
                                🏠
                            </div>

                        @endif

                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">

                                <h5 class="card-title mb-0">
                                    {{ $property->title }}
                                </h5>

                                @if($property->type === 'sale')
                                    <span class="badge bg-success">
                                        للبيع
                                    </span>
                                @else
                                    <span class="badge bg-info text-dark">
                                        للإيجار
                                    </span>
                                @endif

                            </div>

                            <h4 class="text-primary mb-3">
                                ${{ number_format((float) $property->price, 2) }}
                            </h4>

                            <div class="small text-muted mb-2">
                                📍 {{ $property->city }}

                                @if($property->address)
                                    — {{ $property->address }}
                                @endif
                            </div>

                            <div class="small mb-2">
                                📐 المساحة:
                                <strong>{{ $property->area_m2 }} م²</strong>
                            </div>

                            @if($property->building_age !== null)
                                <div class="small mb-2">
                                    🏗️ عمر البناء:
                                    <strong>{{ $property->building_age }} سنة</strong>
                                </div>
                            @endif

                            @if($property->finishing_type)
                                <div class="small mb-2">
                                    🎨 الإكساء:
                                    <strong>{{ $property->finishing_type }}</strong>
                                </div>
                            @endif

                            <div class="small mb-3">

                                @if($property->rooms !== null)
                                    🛏️ {{ $property->rooms }} غرف
                                @endif

                                @if($property->bathrooms !== null)
                                    &nbsp; | &nbsp;
                                    🚿 {{ $property->bathrooms }} حمامات
                                @endif

                            </div>

                            <div class="mt-auto">

                                <a
                                    href="{{ route('properties.show', $property->id) }}"
                                    class="btn btn-outline-primary w-100">
                                    عرض تفاصيل العقار
                                </a>

                            </div>

                        </div>

                        <div class="card-footer bg-transparent">

                            <small class="text-muted">
                                بواسطة:
                                {{ $property->user->name ?? 'مستخدم' }}
                            </small>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-4">
            {{ $properties->links() }}
        </div>

    @else

        <div class="card shadow-sm">
            <div class="card-body text-center py-5">

                <div style="font-size:60px;">
                    🏠
                </div>

                <h4 class="mt-3">
                    لا توجد عقارات
                </h4>

                <p class="text-muted">
                    لا توجد عقارات معتمدة مطابقة للبحث الحالي.
                </p>

                @auth
                    <a
                        href="{{ route('properties.create') }}"
                        class="btn btn-primary">
                        إضافة أول عقار
                    </a>
                @endauth

            </div>
        </div>

    @endif

</div>
@endsection
