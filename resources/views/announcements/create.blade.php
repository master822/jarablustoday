@extends('layouts.app')

@section('title', 'إضافة إعلان')

@section('content')
<div class="container py-4" dir="rtl">

    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="mb-4">📢 إضافة إعلان</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST"
                  action="{{ route('announcements.store') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label">عنوان الإعلان</label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">محتوى الإعلان</label>

                    <textarea
                        name="content"
                        class="form-control"
                        rows="7"
                        required>{{ old('content') }}</textarea>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">رقم الهاتف</label>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            value="{{ old('phone') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">المدينة</label>

                        <input
                            type="text"
                            name="city"
                            class="form-control"
                            value="{{ old('city') }}">
                    </div>

                </div>

                <div class="mb-4">
                    <label class="form-label">صورة الإعلان</label>

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept="image/*">
                </div>

                <button class="btn btn-primary w-100">
                    إرسال الإعلان للمراجعة
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
