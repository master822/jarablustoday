@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4>{{ $merchant->name }}</h4>
                    @if($merchant->user_type == 'merchant')
                        <small>متجر {{ $merchant->store_name ?? 'غير محدد' }}</small>
                    @elseif($merchant->user_type == 'service_provider')
                        <small>مقدم خدمات</small>
                    @endif
                </div>
                <div class="card-body">
                    <p>{{ $merchant->store_description ?? 'لا يوجد وصف' }}</p>
                    <hr>
                    
                    @if($merchant->user_type == 'merchant' && $merchant->products->count() > 0)
                        <h5>المنتجات ({{ $merchant->products->count() }})</h5>
                        <div class="row">
                            @foreach($merchant->products as $product)
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6>{{ $product->name }}</h6>
                                            <p class="text-muted">{{ $product->price }} ل.س</p>
                                            <a href="/products/{{ $product->id }}" class="btn btn-sm" style="background: #d4af37; color: white;">عرض المنتج</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    @if(($merchant->user_type == 'service_provider' || $merchant->user_type == 'other') && $merchant->services->count() > 0)
                        <h5 class="mt-4">الخدمات المقدمة ({{ $merchant->services->count() }})</h5>
                        <div class="row">
                            @foreach($merchant->services as $service)
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6>{{ $service->service_name }}</h6>
                                            <p class="text-muted">{{ Str::limit($service->description, 80) }}</p>
                                            <p><small><strong>المدينة:</strong> {{ $service->city ?? 'غير محدد' }}</small></p>
                                            @if($service->price)
                                                <p><small><strong>السعر:</strong> {{ $service->price }} ل.س</small></p>
                                            @endif
                                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-sm" style="background: #d4af37; color: white;">
                                                <i class="fas fa-eye"></i> عرض الخدمة
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
