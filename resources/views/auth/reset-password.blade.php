@extends('layouts.app')

@section('title', 'إعادة تعيين كلمة المرور')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-rizk p-4">
                <h4 class="text-center mb-4" style="color: var(--text-primary);">
                    <i class="fas fa-lock me-2"></i>إعادة تعيين كلمة المرور
                </h4>
                
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-control form-rizk" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">كلمة المرور الجديدة *</label>
                        <input type="password" name="password" class="form-control form-rizk" required>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">تأكيد كلمة المرور *</label>
                        <input type="password" name="password_confirmation" class="form-control form-rizk" required>
                    </div>
                    
                    <button type="submit" class="btn btn-rizk-primary w-100">
                        <i class="fas fa-save me-2"></i>إعادة تعيين كلمة المرور
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
