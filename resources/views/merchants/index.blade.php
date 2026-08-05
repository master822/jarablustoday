@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>جميع التجار</h2>
    <div class="row">
        @foreach($merchants as $merchant)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>{{ $merchant->name }}</h5>
                        <p>{{ $merchant->store_name ?? 'متجر غير محدد' }}</p>
                        <a href="/merchants/{{ $merchant->id }}" class="btn btn-sm" style="background: #d4af37; color: white;">عرض المتجر</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
