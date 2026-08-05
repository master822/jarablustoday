@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4 class="mb-0">الملف الشخصي</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">المدينة</label>
                            <input type="text" class="form-control" name="city" value="{{ $user->city }}">
                        </div>
                        
                        <button type="submit" class="btn w-100" style="background: #d4af37; color: white;">
                            حفظ التغييرات
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
