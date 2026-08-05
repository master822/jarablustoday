@extends('layouts.app')

@section('title', 'تعديل المستخدم')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h4 class="text-center mb-4" style="color: var(--text-primary);">تعديل المستخدم</h4>
                
                <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الاسم</label>
                        <input type="text" name="name" class="form-control form-rizk" value="{{ $user->name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control form-rizk" value="{{ $user->email }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control form-rizk" value="{{ $user->phone }}">
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">المدينة</label>
                        <input type="text" name="city" class="form-control form-rizk" value="{{ $user->city }}">
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">نوع المستخدم</label>
                        <select name="user_type" class="form-select form-rizk" required>
                            <option value="user" {{ $user->user_type == 'user' ? 'selected' : '' }}>مستخدم عادي</option>
                            <option value="merchant" {{ $user->user_type == 'merchant' ? 'selected' : '' }}>تاجر</option>
                            <option value="admin" {{ $user->user_type == 'admin' ? 'selected' : '' }}>مسؤول</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" {{ $user->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active" style="color: var(--text-primary);">نشط</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">كلمة المرور (اتركها فارغة إذا لم تريد تغييرها)</label>
                        <input type="password" name="password" class="form-control form-rizk">
                    </div>
                    
                    <button type="submit" class="btn btn-rizk-primary w-100">تحديث المستخدم</button>
                    <a href="{{ route('admin.users') }}" class="btn btn-rizk-outline w-100 mt-2">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
