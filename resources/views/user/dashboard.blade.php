@extends('layouts.app')

@section('title', 'لوحة التحكم - مستخدم')

@section('content')
<div class="container py-4">
    <h4 class="section-title-rizk">لوحة التحكم</h4>
    <p style="color: var(--text-muted);">مرحباً {{ Auth::user()->name }} 👋</p>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $products->total() }}</h2>
                <p style="color: var(--text-muted);">المنتجات</p>
                <a href="{{ route('user.products') }}" class="btn btn-rizk-outline btn-sm">عرض الكل</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $messages }}</h2>
                <p style="color: var(--text-muted);">الرسائل غير المقروءة</p>
                <a href="{{ route('user.messages') }}" class="btn btn-rizk-outline btn-sm">عرض الكل</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-rizk text-center p-3">
                <i class="fas fa-user fa-3x gold-text mb-2"></i>
                <p style="color: var(--text-muted);">الملف الشخصي</p>
                <a href="{{ route('user.profile') }}" class="btn btn-rizk-primary btn-sm">تعديل الملف الشخصي</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-rizk p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 style="color: var(--text-primary);">منتجاتي الأخيرة</h6>
                    <a href="{{ route('user.products.create') }}" class="btn btn-rizk-primary btn-sm">+ إضافة منتج</a>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th>السعر</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 2) }} $</td>
                                <td><span class="badge-rizk badge-rizk-gold">{{ $product->condition }}</span></td>
                                <td>
                                    <a href="{{ route('user.products.edit', $product->id) }}" class="btn btn-sm btn-rizk-outline">تعديل</a>
                                    <form action="{{ route('user.products.delete', $product->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center">لا توجد منتجات</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
