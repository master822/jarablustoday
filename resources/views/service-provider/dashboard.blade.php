@extends('layouts.app')

@section('title', 'لوحة تحكم مقدم الخدمات')

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
                    
                    <!-- ===== زر رابط الملف الشخصي ===== -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5><i class="fas fa-link" style="color: #d4af37;"></i> رابط ملفك الشخصي</h5>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="storeUrl" value="{{ $storeUrl }}" readonly>
                                        <button class="btn" style="background: #d4af37; color: white;" onclick="copyStoreUrl()">
                                            <i class="fas fa-copy"></i> نسخ
                                        </button>
                                        <button class="btn" style="background: #25D366; color: white;" onclick="shareWhatsApp()">
                                            <i class="fab fa-whatsapp"></i> مشاركة
                                        </button>
                                    </div>
                                    <small class="text-muted">شارك هذا الرابط مع عملائك لزيارة ملفك الشخصي</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="fas fa-tools fa-3x" style="color: #d4af37;"></i>
                                    <h5 class="mt-3">خدماتي</h5>
                                    <p class="text-muted">{{ $services }} خدمة</p>
                                    <a href="{{ route('service-provider.services') }}" class="btn btn-gold">إدارة الخدمات</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <i class="fas fa-briefcase fa-3x" style="color: #d4af37;"></i>
                                    <h5 class="mt-3">فرص العمل</h5>
                                    <p class="text-muted">{{ $jobs }} فرصة</p>
                                    <a href="{{ route('service-provider.jobs') }}" class="btn btn-gold">إدارة فرص العمل</a>
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

@push('scripts')
<script>
function copyStoreUrl() {
    var copyText = document.getElementById('storeUrl');
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert('تم نسخ الرابط بنجاح!');
}

function shareWhatsApp() {
    var url = document.getElementById('storeUrl').value;
    var message = 'مرحباً، يمكنك زيارة ملفي الشخصي عبر الرابط التالي:\n' + url;
    var whatsappUrl = 'https://wa.me/?text=' + encodeURIComponent(message);
    window.open(whatsappUrl, '_blank');
}
</script>
@endpush
