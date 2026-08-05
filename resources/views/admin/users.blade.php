@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="section-title-rizk">👥 إدارة المستخدمين</h4>
        <span class="badge-rizk badge-rizk-gold">{{ $users->total() }} مستخدم</span>
    </div>
    
    <div class="card-rizk p-3">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني</th>
                        <th>النوع</th>
                        <th>الهاتف</th>
                        <th>الحالة</th>
                        <th>تاريخ التسجيل</th>
                        <th>الباقة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $user->user_type == 'admin' ? 'danger' : ($user->user_type == 'merchant' ? 'primary' : 'secondary') }}">
                                    {{ $user->user_type }}
                                </span>
                            </td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">
                                    {{ $user->is_active ? 'نشط' : 'غير نشط' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d') }}</td>
                            <td>
                                @php
                                    $sub = $user->subscriptions->first();
                                @endphp
                                @if($sub && $sub->status == 'active')
                                    <span class="badge bg-success">{{ $sub->plan == 'medium' ? 'متوسطة' : 'ذهبية' }}</span>
                                @else
                                    <span class="badge bg-secondary">لا يوجد</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.user.show', $user->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" class="d-inline">
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
                            <td colspan="9" class="text-center">لا توجد مستخدمين</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $users->links() }}
    </div>
</div>
@endsection
