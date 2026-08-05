@extends('layouts.app')

@section('title', 'الملف الشخصي - المسؤول')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h4 class="text-center mb-4" style="color: var(--text-primary);">
                    <i class="fas fa-user-shield me-2"></i>الملف الشخصي للمسؤول
                </h4>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <div class="text-center mb-4">
@if(session('site_logo'))
    <img src="{{ asset('storage/' . session('site_logo')) }}" 
         alt="شعار الموقع" 
         style="max-height: 100px; max-width: 250px; width: auto; border-radius: 8px; object-fit: contain;">
@else
    <div class="brand-icon mx-auto" style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 2rem; margin: 0 auto;">
        <i class="fas fa-gem"></i>
    </div>
@endif
                </div>
                
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
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
                        <label style="color: var(--text-primary);">كلمة المرور (اتركها فارغة إذا لم تريد تغييرها)</label>
                        <input type="password" name="password" class="form-control form-rizk">
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">اسم الموقع</label>
                        <input type="text" name="site_name" class="form-control form-rizk" value="{{ session('site_name', 'Rizk') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">شعار الموقع</label>
                        <input type="file" name="logo" class="form-control form-rizk" accept="image/*">
                        <small style="color: var(--text-muted);">ارفع صورة جديدة لشعار الموقع (JPG, PNG)</small>
                    </div>
                    
                    <button type="submit" class="btn btn-rizk-primary w-100">تحديث الملف الشخصي</button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-rizk-outline w-100 mt-2">العودة للوحة التحكم</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
