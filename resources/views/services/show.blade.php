@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4>{{ $service->service_name }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>الوصف:</strong></p>
                    <p>{{ $service->description }}</p>
                    <hr>
                    <p><strong>المدينة:</strong> {{ $service->city ?? 'غير محدد' }}</p>
                    <p><strong>مقدم الخدمة:</strong> {{ $service->user->name ?? 'غير معروف' }}</p>
                    
                    @if($service->price)
                        <p><strong>السعر:</strong> {{ $service->price }} ل.س</p>
                    @endif
                    
                    @auth
                        @if(Auth::id() != $service->user_id)
                            <div class="mt-4">
                                <a href="{{ route('messages.contact.provider', $service->user_id) }}" class="btn" style="background: #28a745; color: white;">
                                    <i class="fas fa-envelope"></i> التواصل مع مقدم الخدمة
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn" style="background: #28a745; color: white;">
                                <i class="fas fa-sign-in-alt"></i> سجل الدخول للتواصل
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
