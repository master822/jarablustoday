@extends('layouts.app')

@section('title', 'لوحة التحكم - تاجر')

@section('content')
<div class="container py-4">
    <h4 class="section-title-rizk">لوحة التحكم - التاجر</h4>
    <p style="color: var(--text-muted);">مرحباً {{ Auth::user()->name }} 👋</p>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $products }}</h2>
                <p style="color: var(--text-muted);">المنتجات</p>
                <a href="{{ route('merchant.products') }}" class="btn btn-rizk-outline btn-sm">عرض</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $discounts }}</h2>
                <p style="color: var(--text-muted);">التخفيضات</p>
                <a href="{{ route('merchant.discounts') }}" class="btn btn-rizk-outline btn-sm">عرض</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $jobs }}</h2>
                <p style="color: var(--text-muted);">فرص العمل</p>
                <a href="{{ route('merchant.jobs') }}" class="btn btn-rizk-outline btn-sm">عرض</a>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <i class="fas fa-user fa-3x gold-text mb-2"></i>
                <p style="color: var(--text-muted);">الملف الشخصي</p>
                <a href="{{ route('merchant.profile') }}" class="btn btn-rizk-primary btn-sm">تعديل</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-rizk p-3">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('merchant.products.create') }}" class="btn btn-rizk-primary">+ إضافة منتج</a>
                    <a href="{{ route('merchant.discounts.create') }}" class="btn btn-rizk-secondary">+ إضافة تخفيض</a>
                    <a href="{{ route('merchant.jobs.create') }}" class="btn btn-rizk-success">+ نشر فرصة عمل</a>
                    <a href="{{ route('merchant.profile') }}" class="btn btn-rizk-outline">تعديل الملف الشخصي</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
