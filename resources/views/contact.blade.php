@extends('layouts.app')

@section('title', 'اتصل بنا - Rizk')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-header text-white text-center py-4" style="background: #d4af37;">
                    <h2 class="mb-0 fw-bold">اتصل بنا</h2>
                </div>
                <div class="card-body p-5">
                    <p class="text-center mb-4">نحن هنا لمساعدتك! تواصل معنا عبر أي من وسائل الاتصال التالية:</p>
                    
                    <div class="row g-4">
                        <!-- الهاتف -->
                        <div class="col-md-6">
                            <div class="card h-100 text-center p-4" style="border: 1px solid #e9ecef;">
                                <div style="font-size: 40px; color: #d4af37;">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h5 class="mt-3">📞 الهاتف</h5>
                                <p class="mb-0"><a href="tel:+963939128784" style="color: #d4af37; text-decoration: none; font-size: 18px;">+963 939 128 784</a></p>
                            </div>
                        </div>
                        
                        <!-- البريد الإلكتروني -->
                        <div class="col-md-6">
                            <div class="card h-100 text-center p-4" style="border: 1px solid #e9ecef;">
                                <div style="font-size: 40px; color: #d4af37;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h5 class="mt-3">✉️ البريد الإلكتروني</h5>
                                <p class="mb-0"><a href="mailto:mastersniper823@gmail.com" style="color: #d4af37; text-decoration: none; font-size: 18px;">mastersniper823@gmail.com</a></p>
                            </div>
                        </div>
                        
                        <!-- الموقع -->
                        <div class="col-md-6">
                            <div class="card h-100 text-center p-4" style="border: 1px solid #e9ecef;">
                                <div style="font-size: 40px; color: #d4af37;">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <h5 class="mt-3">🌐 الموقع</h5>
                                <p class="mb-0"><a href="{{ url('/') }}" style="color: #d4af37; text-decoration: none; font-size: 18px;">rizk-6iq1.onrender.com</a></p>
                            </div>
                        </div>
                        
                        <!-- ساعات العمل -->
                        <div class="col-md-6">
                            <div class="card h-100 text-center p-4" style="border: 1px solid #e9ecef;">
                                <div style="font-size: 40px; color: #d4af37;">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h5 class="mt-3">🕐 ساعات العمل</h5>
                                <p class="mb-0">جميع الأيام: 24 ساعة</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- نموذج التواصل -->
                    <h5 class="text-center mb-4" style="color: #d4af37;">أرسل رسالة مباشرة</h5>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">الاسم</label>
                                <input type="text" name="name" class="form-control" required placeholder="أدخل اسمك">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">البريد الإلكتروني</label>
                                <input type="email" name="email" class="form-control" required placeholder="example@email.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">الموضوع</label>
                            <input type="text" name="subject" class="form-control" required placeholder="موضوع الرسالة">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">الرسالة</label>
                            <textarea name="message" class="form-control" rows="5" required placeholder="اكتب رسالتك هنا..."></textarea>
                        </div>
                        <button type="submit" class="btn w-100 text-white py-3 fw-bold" style="background: #d4af37; border: none; border-radius: 10px; font-size: 1.1rem;">
                            <i class="fas fa-paper-plane me-2"></i>إرسال الرسالة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
