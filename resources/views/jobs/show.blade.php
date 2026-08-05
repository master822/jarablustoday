@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4>{{ $job->title }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>الوصف:</strong></p>
                    <p>{{ $job->description }}</p>
                    <hr>
                    <p><strong>الفئة:</strong> {{ $job->category }}</p>
                    <p><strong>الموقع:</strong> {{ $job->location ?? 'غير محدد' }}</p>
                    @if($job->salary_min || $job->salary_max)
                        <p><strong>الراتب:</strong> {{ $job->salary_min ?? '' }} - {{ $job->salary_max ?? '' }}</p>
                    @endif
                    <p><strong>الناشر:</strong> {{ $job->user->name ?? 'غير معروف' }}</p>
                    
                    @auth
                        @if(Auth::id() != $job->user_id)
                            <div class="mt-4">
                                <a href="{{ route('messages.contact.job', $job->id) }}" class="btn" style="background: #28a745; color: white;">
                                    <i class="fas fa-envelope"></i> التواصل مع الناشر
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
