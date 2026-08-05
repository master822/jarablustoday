@extends('layouts.app')

@section('title', 'تغيير كلمة المرور')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-rizk p-4">
                <h5 style="color: var(--text-primary);">تغيير كلمة المرور</h5>
                <form action="{{ route('change-password.update') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">كلمة المرور الحالية</label>
                        <input type="password" name="current_password" class="form-control form-rizk" required>
                        @error('current_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" class="form-control form-rizk" required>
                        @error('new_password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="new_password_confirmation" class="form-control form-rizk" required>
                    </div>
                    <button type="submit" class="btn btn-rizk-primary">تغيير كلمة المرور</button>
                    <a href="{{ route('profile') }}" class="btn btn-rizk-outline">إلغاء</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
