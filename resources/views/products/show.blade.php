@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h2>{{ $product->name }}</h2>
                    <p><strong>السعر:</strong> {{ $product->price }} ل.س</p>
                    <p><strong>الوصف:</strong> {{ $product->description }}</p>
                    <p><strong>الحالة:</strong> {{ $product->condition ?? 'جديد' }}</p>
                    <p><strong>البائع:</strong> {{ $product->user->name ?? 'غير معروف' }}</p>
                    
                    @auth
                        @if(Auth::id() != $product->user_id)
                            <a href="{{ route('messages.contact.form', $product->id) }}" class="btn" style="background: #28a745; color: white;">
                                <i class="fas fa-envelope"></i> التواصل مع البائع
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn" style="background: #28a745; color: white;">
                            <i class="fas fa-sign-in-alt"></i> سجل الدخول للتواصل
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
