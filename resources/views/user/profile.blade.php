@extends('layouts.app')

@section('title', 'الملف الشخصي')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h4 class="text-center mb-4" style="color: var(--text-primary);">الملف الشخصي</h4>
                
                <div class="text-center mb-4">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" 
                             class="rounded-circle" 
                             width="120" height="120" 
                             style="object-fit: cover; border: 3px solid var(--primary-color);">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=120&background=d4af37&color=fff" 
                             class="rounded-circle" 
                             width="120" height="120">
                    @endif
                </div>
                
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الاسم</label>
                        <input type="text" name="name" class="form-control form-rizk" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">البريد الإلكتروني</label>
                        <input type="email" class="form-control form-rizk" value="{{ Auth::user()->email }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control form-rizk" value="{{ Auth::user()->phone }}">
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">المدينة</label>
                        <input type="text" name="city" class="form-control form-rizk" value="{{ Auth::user()->city }}">
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">الصورة الشخصية</label>
                        <input type="file" name="avatar" class="form-control form-rizk" accept="image/*">
                    </div>
                    <button type="submit" class="btn btn-rizk-primary w-100">حفظ التغييرات</button>
                </form>
                
                <div class="mt-3 text-center">
                    <a href="{{ route('user.change-password') }}" class="btn btn-rizk-outline w-100">تغيير كلمة المرور</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
