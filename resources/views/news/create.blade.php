@extends('layouts.app')

@section('title', 'إضافة خبر')

@section('content')
<div class="container py-4" dir="rtl">

    <div class="card shadow-sm">
        <div class="card-body">

            <h2 class="mb-4">📰 إضافة خبر</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST"
                  action="{{ route('news.store') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">
                    <label class="form-label">عنوان الخبر</label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="{{ old('title') }}"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">محتوى الخبر</label>

                    <textarea
                        name="content"
                        class="form-control"
                        rows="8"
                        required>{{ old('content') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">صورة الخبر</label>

                    <input
                        type="file"
                        name="image"
                        class="form-control"
                        accept="image/*">
                </div>

                <button class="btn btn-primary w-100">
                    إرسال الخبر للمراجعة
                </button>

            </form>

        </div>
    </div>

</div>
@endsection
