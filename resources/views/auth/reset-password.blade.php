@extends('layouts.app')

@section('title', 'إعادة تعيين كلمة المرور')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header text-white text-center py-4" style="background: #d4af37; border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0 fw-bold">إعادة تعيين كلمة المرور</h4>
                    <p class="mb-0 small text-white-50">أدخل كلمة المرور الجديدة</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">البريد الإلكتروني</label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required 
                                   placeholder="example@email.com" style="border-radius: 10px;">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">كلمة المرور الجديدة</label>
                            <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required placeholder="********" style="border-radius: 10px;">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold small">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control form-control-lg" 
                                   name="password_confirmation" required placeholder="********" style="border-radius: 10px;">
                        </div>

                        <button type="submit" class="btn w-100 py-3 text-white fw-bold" 
                                style="background: #d4af37; border: none; border-radius: 10px; font-size: 1.1rem;">
                            إعادة تعيين كلمة المرور
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
