@extends('layouts.app')

@section('title', 'المنتجات')

@section('content')
<div class="container py-4">
    <h4 class="section-title-rizk">📦 المنتجات</h4>
    
    <div class="card-rizk p-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المنتج</th>
                        <th>البائع</th>
                        <th>السعر</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->user->name ?? 'غير معروف' }}</td>
                            <td>{{ number_format($product->price, 2) }} TL</td>
                            <td>
                                <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'danger' }}">
                                    {{ $product->status }}
                                </span>
                            </td>
                            <td>{{ $product->created_at->format('Y-m-d') }}</td>
                            <td>
                                <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">لا توجد منتجات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $products->links() }}
    </div>
</div>
@endsection
