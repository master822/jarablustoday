@extends('layouts.app')

@section('title', 'إضافة منتج جديد')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h5 style="color: var(--text-primary);">إضافة منتج جديد</h5>
                <form action="{{ route('merchant.products.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label style="color: var(--text-primary);">عدد القطع المتاحة *</label>
                        <input type="number" name="quantity" class="form-control form-rizk" value="1" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">نوع المنتج</label>
                        <select name="condition" class="form-select form-rizk">
                            <option value="new">جديد</option>
                            <option value="used">مستعمل</option>
                            <option value="other">أخرى</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الصور</label>
                        <input type="file" name="images[]" class="form-control form-rizk" accept="image/*" multiple>
                    </div>
                    <button type="submit" class="btn btn-rizk-primary">إضافة المنتج</button>
                    <a href="{{ route('merchant.products') }}" class="btn btn-rizk-outline">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
