@extends('layouts.app')

@section('title', 'لوحة تحكم المسؤول')

@section('content')
<div class="container py-4">
    <h1 class="section-title-rizk">لوحة تحكم المسؤول</h1>
    
<div class="row g-3 mt-3">
    <div class="col-12">
        <div class="card-rizk p-3">
            <h6 style="color: var(--text-primary);">📤 تصدير البيانات</h6>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <a href="{{ route('export.products') }}" class="btn btn-rizk-outline btn-sm">
                    <i class="fas fa-file-csv me-1"></i>تصدير المنتجات
                </a>
                <a href="{{ route('export.services') }}" class="btn btn-rizk-outline btn-sm">
                    <i class="fas fa-file-csv me-1"></i>تصدير الخدمات
                </a>
                <a href="{{ route('export.users') }}" class="btn btn-rizk-outline btn-sm">
                    <i class="fas fa-file-csv me-1"></i>تصدير المستخدمين
                </a>
                <a href="{{ route('export.discounts') }}" class="btn btn-rizk-outline btn-sm">
                    <i class="fas fa-file-csv me-1"></i>تصدير التخفيضات
                </a>
            </div>
        </div>
    </div>
</div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $totalUsers }}</h2>
                <p style="color: var(--text-muted);">👥 إجمالي المستخدمين</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $totalMerchants }}</h2>
                <p style="color: var(--text-muted);">🏪 التجار</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $totalProducts }}</h2>
                <p style="color: var(--text-muted);">📦 المنتجات</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $totalSubscriptions }}</h2>
                <p style="color: var(--text-muted);">📋 الاشتراكات النشطة</p>
            </div>
        </div>
    </div>
    
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card-rizk text-center p-3">
                <h2 style="color: var(--primary-color);">{{ $pendingPayments }}</h2>
                <p style="color: var(--text-muted);">💰 طلبات دفع معلقة</p>
                <a href="{{ route('admin.payments') }}" class="btn btn-rizk-primary btn-sm">عرض الكل</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-rizk text-center p-3">
                <i class="fas fa-users fa-3x gold-text mb-2"></i>
                <p style="color: var(--text-muted);">إدارة المستخدمين</p>
                <a href="{{ route('admin.users') }}" class="btn btn-rizk-primary btn-sm">إدارة</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card-rizk text-center p-3">
                <i class="fas fa-crown fa-3x gold-text mb-2"></i>
                <p style="color: var(--text-muted);">إدارة الاشتراكات</p>
                <a href="{{ route('admin.subscriptions') }}" class="btn btn-rizk-primary btn-sm">إدارة</a>
            </div>
        </div>
    </div>
    
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card-rizk p-3">
                <h6 style="color: var(--text-primary);">👤 أحدث المستخدمين</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>النوع</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->user_type }}</td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-rizk p-3">
                <h6 style="color: var(--text-primary);">📋 أحدث الاشتراكات</h6>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>المستخدم</th>
                                <th>الباقة</th>
                                <th>الحالة</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSubscriptions as $sub)
                                <tr>
                                    <td>{{ $sub->user->name ?? 'غير معروف' }}</td>
                                    <td>{{ $sub->plan == 'medium' ? 'متوسطة' : 'ذهبية' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $sub->status == 'active' ? 'success' : 'warning' }}">
                                            {{ $sub->status }}
                                        </span>
                                    </td>
                                    <td>{{ $sub->created_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
