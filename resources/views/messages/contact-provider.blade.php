@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header" style="background: #d4af37; color: white;">
                    <h4 class="mb-0">التواصل مع {{ $provider->name }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('messages.contact.provider.send', $provider->id) }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">الرسالة</label>
                            <textarea class="form-control" name="message" rows="5" required placeholder="اكتب رسالتك هنا..."></textarea>
                        </div>
                        <button type="submit" class="btn w-100" style="background: #d4af37; color: white;">
                            <i class="fas fa-paper-plane"></i> إرسال الرسالة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
