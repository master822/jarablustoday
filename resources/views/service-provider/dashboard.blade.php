@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4 class="mb-0">لوحة تحكم مقدم الخدمات</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        مرحباً بك {{ Auth::user()->name }}
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-tools fa-3x" style="color: #d4af37;"></i>
                                    <h5 class="mt-2">خدماتي</h5>
                                    <p class="text-muted">{{ $services->count() }} خدمات</p>
                                    <a href="{{ route('service-provider.services') }}" class="btn btn-sm" style="background: #d4af37; color: white;">إدارة الخدمات</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <i class="fas fa-user fa-3x" style="color: #d4af37;"></i>
                                    <h5 class="mt-2">الملف الشخصي</h5>
                                    <a href="{{ route('profile') }}" class="btn btn-sm" style="background: #d4af37; color: white;">تعديل الملف</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
