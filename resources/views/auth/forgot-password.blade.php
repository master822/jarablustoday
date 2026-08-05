@extends('layouts.app')

@section('title', 'نسيان كلمة المرور')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-rizk p-4">
                <h4 class="text-center mb-4" style="color: var(--text-primary);">
                    <i class="fas fa-key me-2"></i>نسيان كلمة المرور
                </h4>
                
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                
                <p style="color: var(--text-muted);" class="text-center mb-4">
                    أدخل بريدك الإلكتروني وسنرسل لك رابطاً لإعادة تعيين كلمة المرور
                </p>
                
                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-control form-rizk" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-rizk-primary w-100">
                        <i class="fas fa-paper-plane me-2"></i>إرسال رابط إعادة التعيين
                    </button>
                </form>
                
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" style="color: var(--text-muted);">
                        <i class="fas fa-arrow-right me-1"></i>العودة لتسجيل الدخول
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
