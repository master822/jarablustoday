@extends('layouts.app')

@section('title', 'إضافة عقار')

@section('content')
<div class="container py-4" dir="rtl">

    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="mb-4">🏠 إضافة عقار جديد</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('properties.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">نوع العقار *</label>

                    <div class="d-flex gap-3">

                        <label class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="type"
                                value="sale"
                                {{ old('type') === 'sale' ? 'checked' : '' }}
                                required>
                            <span class="form-check-label">
                                🏷️ للبيع
                            </span>
                        </label>

                        <label class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="type"
                                value="rent"
                                {{ old('type') === 'rent' ? 'checked' : '' }}>
                            <span class="form-check-label">
                                🔑 للإيجار
                            </span>
                        </label>

                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">عنوان العقار *</label>
                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title') }}"
                        placeholder="مثال: منزل طابقين في جرابلس"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">وصف العقار *</label>
                    <textarea
                        name="description"
                        class="form-control"
                        rows="5"
                        placeholder="اكتب تفاصيل العقار..."
                        required>{{ old('description') }}</textarea>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            السعر بالدولار الأمريكي *
                        </label>

                        <div class="input-group">
                            <input
                                type="number"
                                name="price"
                                class="form-control"
                                min="0"
                                step="0.01"
                                value="{{ old('price') }}"
                                placeholder="مثال: 25000"
                                required>

                            <span class="input-group-text">$ USD</span>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">المدينة *</label>

                        <input
                            type="text"
                            name="city"
                            class="form-control"
                            value="{{ old('city') }}"
                            placeholder="مثال: جرابلس"
                            required>
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">الموقع / العنوان بالتحديد</label>

                    <input
                        type="text"
                        name="address"
                        class="form-control"
                        value="{{ old('address') }}"
                        placeholder="مثال: شارع البلدية، قرب السوق">
                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label class="form-label">المساحة بالمتر المربع *</label>

                        <div class="input-group">
                            <input
                                type="number"
                                name="area_m2"
                                class="form-control"
                                min="1"
                                value="{{ old('area_m2') }}"
                                placeholder="150"
                                required>

                            <span class="input-group-text">م²</span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">عمر البناء</label>

                        <div class="input-group">
                            <input
                                type="number"
                                name="building_age"
                                class="form-control"
                                min="0"
                                value="{{ old('building_age') }}"
                                placeholder="5">

                            <span class="input-group-text">سنة</span>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">نوع الإكساء</label>

                        <select name="finishing_type" class="form-select">
                            <option value="">اختر نوع الإكساء</option>
                            <option value="عادي" {{ old('finishing_type') === 'عادي' ? 'selected' : '' }}>
                                عادي
                            </option>
                            <option value="جيد" {{ old('finishing_type') === 'جيد' ? 'selected' : '' }}>
                                جيد
                            </option>
                            <option value="جيد جداً" {{ old('finishing_type') === 'جيد جداً' ? 'selected' : '' }}>
                                جيد جداً
                            </option>
                            <option value="فاخر" {{ old('finishing_type') === 'فاخر' ? 'selected' : '' }}>
                                فاخر
                            </option>
                            <option value="سوبر ديلوكس" {{ old('finishing_type') === 'سوبر ديلوكس' ? 'selected' : '' }}>
                                سوبر ديلوكس
                            </option>
                        </select>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">عدد الغرف</label>

                        <input
                            type="number"
                            name="rooms"
                            class="form-control"
                            min="0"
                            value="{{ old('rooms') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">عدد الحمامات</label>

                        <input
                            type="number"
                            name="bathrooms"
                            class="form-control"
                            min="0"
                            value="{{ old('bathrooms') }}">
                    </div>

                </div>

                <input type="hidden" name="currency" value="USD">

                <div class="mb-4">
                    <label class="form-label">صور العقار</label>

                    <input
                        type="file"
                        name="images[]"
                        class="form-control"
                        accept="image/*"
                        multiple>

                    <small class="text-muted">
                        يمكنك اختيار أكثر من صورة.
                    </small>
                </div>

                <div class="d-flex gap-2">

                    <button type="submit" class="btn btn-primary">
                        📤 إرسال العقار للمراجعة
                    </button>

                    <a href="{{ url('/properties/sale') }}"
                       class="btn btn-secondary">
                        إلغاء
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
