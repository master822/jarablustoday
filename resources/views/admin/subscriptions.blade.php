@extends('layouts.app')

@section('title', 'إدارة الاشتراكات')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title-rizk">📋 إدارة الاشتراكات</h4>
        <span class="badge-rizk badge-rizk-gold">{{ $subscriptions->total() }} اشتراك</span>
    </div>
    
    <div class="card-rizk p-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المستخدم</th>
                        <th>الباقة</th>
                        <th>عدد المنتجات</th>
                        <th>تاريخ البدء</th>
                        <th>تاريخ الانتهاء</th>
                        <th>الأيام المتبقية</th>
                        <th>الحالة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $sub)
                        <tr>
                            <td>{{ $sub->id }}</td>
                            <td>{{ $sub->user->name ?? 'غير معروف' }}</td>
                            <td>
                                <span class="badge bg-{{ $sub->plan == 'gold' ? 'warning' : 'secondary' }}">
                                    {{ $sub->plan == 'medium' ? 'متوسطة' : 'ذهبية' }}
                                </span>
                            </td>
                            <td>{{ $sub->product_limit }}</td>
                            <td>{{ $sub->start_date->format('Y-m-d') }}</td>
                            <td>{{ $sub->end_date->format('Y-m-d') }}</td>
                            <td>
                                @php
                                    $daysLeft = ceil(now()->diffInDays($sub->end_date, false));
                                @endphp
                                <span class="badge bg-{{ $daysLeft > 30 ? 'success' : ($daysLeft > 7 ? 'warning' : 'danger') }}">
                                    {{ max(0, $daysLeft) }} يوم
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $sub->status == 'active' ? 'success' : ($sub->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ $sub->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.subscription.show', $sub->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.subscription.edit', $sub->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.subscription.cancel', $sub->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من إلغاء هذا الاشتراك؟')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">لا توجد اشتراكات</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $subscriptions->links() }}
    </div>
</div>
@endsection
