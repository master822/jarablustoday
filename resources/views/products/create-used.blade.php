@extends('layouts.app')

@section('title', 'إضافة منتج مستعمل')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h5 style="color: var(--text-primary);">إضافة منتج مستعمل</h5>
                <form action="{{ route('user.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">اسم المنتج *</label>
                        <input type="text" name="name" class="form-control form-rizk" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الوصف *</label>
                        <textarea name="description" class="form-control form-rizk" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">السعر *</label>
                        <input type="number" name="price" class="form-control form-rizk" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">حالة المنتج *</label>
                        <select name="condition" class="form-select form-rizk" required>
                            <option value="">-- اختر حالة المنتج --</option>
                            <option value="ممتاز">ممتاز</option>
                            <option value="جيد جدا">جيد جداً</option>
                            <option value="جيد">جيد</option>
                            <option value="مقبول">مقبول</option>
                            <option value="بحال الجديد">بحال الجديد</option>
                            <option value="used">مستعمل</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الصور</label>
                        <input type="file" name="images[]" class="form-control form-rizk" accept="image/*" multiple>
                    </div>
                    <button type="submit" class="btn btn-rizk-primary">إضافة المنتج</button>
                    <a href="{{ route('user.products') }}" class="btn btn-rizk-outline">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
