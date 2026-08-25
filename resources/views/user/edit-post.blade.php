@extends('layouts.app')

@section('title', 'تعديل المنشور')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="section-title-rizk">تعديل المنشور</h4>
            <p style="color:var(--text-muted);">
                تعديل {{ $type === 'news' ? 'الخبر' : ($type === 'announcement' ? 'الإعلان' : 'العقار') }}
            </p>
        </div>

        <a href="{{ route('user.posts') }}" class="btn btn-rizk-outline">
            العودة إلى منشوراتي
        </a>
    </div>

    <div class="card-rizk p-4">

        <form method="POST"
              action="{{ route('user.posts.update', [$type, $post->id]) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            @if($type === 'news')

                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title', $post->title) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">المحتوى</label>
                    <textarea name="content"
                              class="form-control"
                              rows="8"
                              required>{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">الصورة</label>
                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*">
                </div>

            @elseif($type === 'announcement')

                <div class="mb-3">
                    <label class="form-label">العنوان</label>
                    <input type="text"
                           name="title"
                           class="form-control"
                           value="{{ old('title', $post->title) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">المحتوى</label>
                    <textarea name="content"
                              class="form-control"
                              rows="8"
                              required>{{ old('content', $post->content) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ old('phone', $post->phone) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">المدينة</label>
                        <input type="text"
                               name="city"
                               class="form-control"
                               value="{{ old('city', $post->city) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">الصورة</label>
                    <input type="file"
                           name="image"
                           class="form-control"
                           accept="image/*">
                </div>

            @elseif($type === 'property')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع العقار</label>
                        <select name="type" class="form-select" required>
                            <option value="sale" {{ old('type', $post->type) === 'sale' ? 'selected' : '' }}>
                                للبيع
                            </option>
                            <option value="rent" {{ old('type', $post->type) === 'rent' ? 'selected' : '' }}>
                                للإيجار
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">العنوان</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $post->title) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">السعر</label>
                        <input type="number"
                               step="0.01"
                               name="price"
                               class="form-control"
                               value="{{ old('price', $post->price) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">المدينة</label>
                        <input type="text"
                               name="city"
                               class="form-control"
                               value="{{ old('city', $post->city) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">المنطقة</label>
                        <input type="text"
                               name="area"
                               class="form-control"
                               value="{{ old('area', $post->area) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">العنوان التفصيلي</label>
                        <input type="text"
                               name="address"
                               class="form-control"
                               value="{{ old('address', $post->address) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">الغرف</label>
                        <input type="number"
                               name="rooms"
                               class="form-control"
                               min="0"
                               value="{{ old('rooms', $post->rooms) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">الحمامات</label>
                        <input type="number"
                               name="bathrooms"
                               class="form-control"
                               min="0"
                               value="{{ old('bathrooms', $post->bathrooms) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">المساحة م²</label>
                        <input type="number"
                               step="0.01"
                               name="area_m2"
                               class="form-control"
                               min="1"
                               value="{{ old('area_m2', $post->area_m2) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">عمر البناء</label>
                        <input type="number"
                               name="building_age"
                               class="form-control"
                               min="0"
                               value="{{ old('building_age', $post->building_age) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">نوع التشطيب</label>
                        <input type="text"
                               name="finishing_type"
                               class="form-control"
                               value="{{ old('finishing_type', $post->finishing_type) }}">
                    </div>

                </div>

                <div class="mb-3">
                    <label class="form-label">الوصف</label>
                    <textarea name="description"
                              class="form-control"
                              rows="8"
                              required>{{ old('description', $post->description) }}</textarea>
                </div>

            @endif

            <div class="alert alert-warning">
                <i class="fas fa-info-circle"></i>
                بعد تعديل المنشور سيتم إعادته إلى حالة
                <strong>قيد المراجعة</strong>
                حتى تتمكن الإدارة من مراجعة التعديل.
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-rizk-primary">
                    <i class="fas fa-save"></i>
                    حفظ التعديلات
                </button>

                <a href="{{ route('user.posts') }}"
                   class="btn btn-rizk-outline">
                    إلغاء
                </a>
            </div>

        </form>

    </div>
</div>
@endsection
