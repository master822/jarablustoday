@extends('layouts.app')

@section('title', 'تفاصيل المستخدم')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title-rizk">تفاصيل المستخدم</h4>
        <a href="{{ route('admin.users') }}" class="btn btn-rizk-outline btn-sm">← العودة</a>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card-rizk p-4">
                <h6 style="color: var(--text-primary);">المعلومات الشخصية</h6>
                <hr>
                <p><strong>الاسم:</strong> {{ $user->name }}</p>
                <p><strong>البريد الإلكتروني:</strong> {{ $user->email }}</p>
                <p><strong>رقم الهاتف:</strong> {{ $user->phone ?? 'غير محدد' }}</p>
                <p><strong>المدينة:</strong> {{ $user->city ?? 'غير محدد' }}</p>
                <p><strong>نوع المستخدم:</strong> 
                    <span class="badge bg-{{ $user->user_type == 'admin' ? 'danger' : ($user->user_type == 'merchant' ? 'primary' : 'secondary') }}">
                        {{ $user->user_type }}
                    </span>
                </p>
                <p><strong>الحالة:</strong> 
                    <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                        {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </p>
                <p><strong>تاريخ التسجيل:</strong> {{ $user->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-rizk p-4">
                <h6 style="color: var(--text-primary);">الاشتراكات</h6>
                <hr>
                @if($user->subscriptions->count() > 0)
                    @foreach($user->subscriptions as $sub)
                        <div class="alert alert-{{ $sub->status == 'active' ? 'success' : 'warning' }}">
                            <strong>{{ $sub->plan == 'medium' ? 'الباقة المتوسطة' : 'الباقة الذهبية' }}</strong>
                            <br>
                            <small>عدد المنتجات: {{ $sub->product_limit }}</small>
                            <br>
                            <small>تبدأ: {{ $sub->start_date->format('Y-m-d') }}</small>
                            <br>
                            <small>تنتهي: {{ $sub->end_date->format('Y-m-d') }}</small>
                            <br>
                            <small>الحالة: {{ $sub->status }}</small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">لا يوجد اشتراكات</p>
                @endif
                
                <h6 class="mt-3" style="color: var(--text-primary);">المنتجات</h6>
                <hr>
                <p><strong>عدد المنتجات:</strong> {{ $user->products->count() }}</p>
                @if($user->products->count() > 0)
                    <ul>
                        @foreach($user->products->take(5) as $product)
                            <li>{{ $product->name }} - {{ number_format($product->price, 2) }} TL</li>
                        @endforeach
                        @if($user->products->count() > 5)
                            <li class="text-muted">... و {{ $user->products->count() - 5 }} منتج آخر</li>
                        @endif
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
