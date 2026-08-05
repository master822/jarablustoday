@extends('layouts.app')

@section('title', 'الدفع - ' . $planData['name'])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h3 class="text-center mb-4" style="color: var(--text-primary);">
                    <i class="fas fa-credit-card me-2"></i>إتمام الدفع
                </h3>
                
                <div class="alert alert-info">
                    <h5 class="mb-2">تفاصيل الباقة</h5>
                    <p><strong>الباقة:</strong> {{ $planData['name'] }}</p>
                    <p><strong>السعر:</strong> ${{ $planData['price'] }} / شهرياً</p>
                    <p><strong>عدد المنتجات:</strong> {{ $planData['product_limit'] }}</p>
                </div>
                
                <div class="payment-info mb-4 p-3" style="background: var(--bg-body); border-radius: 12px;">
                    <h5 class="text-center mb-3">رمز الدفع</h5>
                    <div class="text-center p-3" style="background: #fff; border-radius: 8px; border: 2px dashed var(--primary-color);">
                        <code style="font-size: 1.5rem; font-weight: bold; color: var(--primary-color);">
                            {{ $paymentCode }}
                        </code>
                    </div>
                    <p class="text-center text-muted mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        استخدم هذا الرمز عند إرسال المبلغ
                    </p>
                </div>
                
                <form action="{{ route('subscription.process', $plan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label style="color: var(--text-primary);">إثبات الدفع *</label>
                        <input type="file" name="payment_proof" class="form-control form-rizk" accept="image/*" required>
                        <small style="color: var(--text-muted);">ارفع صورة لإثبات الدفع (JPG, PNG)</small>
                        @error('payment_proof')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-clock me-2"></i>
                        سيتم تفعيل اشتراكك خلال <strong>24 ساعة</strong> من تاريخ إرسال طلب الدفع
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-rizk-primary">
                            <i class="fas fa-paper-plane me-2"></i>إرسال طلب الدفع
                        </button>
                        <a href="{{ route('subscription.plans') }}" class="btn btn-rizk-outline">عودة</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
