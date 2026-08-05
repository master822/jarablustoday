@extends('layouts.app')

@section('title', 'إنشاء حساب جديد')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-rizk p-4">
                <h4 class="text-center mb-4" style="color: var(--text-primary);">إنشاء حساب جديد</h4>
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary);">الاسم الكامل *</label>
                        <input type="text" name="name" class="form-control form-rizk" value="{{ old('name') }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary);">البريد الإلكتروني *</label>
                        <input type="email" name="email" class="form-control form-rizk" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary);">رقم الهاتف *</label>
                        <input type="tel" name="phone" class="form-control form-rizk" placeholder="09xxxxxxxx أو +9639xxxxxxxx" value="{{ old('phone') }}" required>
                        <small style="color: var(--text-muted);">مثال: 0999123456 أو +963999123456</small>
                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary);">المدينة *</label>
                        <select name="city" class="form-select form-rizk" required>
                            <option value="">اختر المدينة</option>
                            <option value="دمشق" {{ old('city') == 'دمشق' ? 'selected' : '' }}>دمشق</option>
                            <option value="حلب" {{ old('city') == 'حلب' ? 'selected' : '' }}>حلب</option>
                            <option value="حمص" {{ old('city') == 'حمص' ? 'selected' : '' }}>حمص</option>
                            <option value="اللاذقية" {{ old('city') == 'اللاذقية' ? 'selected' : '' }}>اللاذقية</option>
                            <option value="حماة" {{ old('city') == 'حماة' ? 'selected' : '' }}>حماة</option>
                            <option value="طرطوس" {{ old('city') == 'طرطوس' ? 'selected' : '' }}>طرطوس</option>
                            <option value="دير الزور" {{ old('city') == 'دير الزور' ? 'selected' : '' }}>دير الزور</option>
                            <option value="السويداء" {{ old('city') == 'السويداء' ? 'selected' : '' }}>السويداء</option>
                            <option value="درعا" {{ old('city') == 'درعا' ? 'selected' : '' }}>درعا</option>
                            <option value="إدلب" {{ old('city') == 'إدلب' ? 'selected' : '' }}>إدلب</option>
                            <option value="الرقة" {{ old('city') == 'الرقة' ? 'selected' : '' }}>الرقة</option>
                            <option value="الحسكة" {{ old('city') == 'الحسكة' ? 'selected' : '' }}>الحسكة</option>
                            <option value="القامشلي" {{ old('city') == 'القامشلي' ? 'selected' : '' }}>القامشلي</option>
                        </select>
                        @error('city')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary);">نوع الحساب *</label>
                        <select name="user_type" id="userType" class="form-select form-rizk" required>
                            <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }}>👤 مستخدم عادي</option>
                            <option value="merchant" {{ old('user_type') == 'merchant' ? 'selected' : '' }}>🏪 تاجر</option>
                            <option value="service_provider" {{ old('user_type') == 'service_provider' ? 'selected' : '' }}>🛎️ مقدم خدمات</option>
                        </select>
                        @error('user_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <!-- حقول التاجر -->
                    <div id="merchantFields" style="display: {{ old('user_type') == 'merchant' ? 'block' : 'none' }};">
                        <div class="card-rizk p-3 mb-3" style="background: var(--bg-card); border: 1px solid rgba(212, 175, 55, 0.1);">
                            <h6 style="color: var(--text-primary);">🏪 بيانات المتجر</h6>
                            <div class="mb-3">
                                <label class="form-label" style="color: var(--text-primary);">اسم المتجر *</label>
                                <input type="text" name="store_name" class="form-control form-rizk" value="{{ old('store_name') }}">
                                @error('store_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" style="color: var(--text-primary);">فئة المتجر *</label>
                                <select name="store_category" class="form-select form-rizk">
                                    <option value="">اختر فئة المتجر</option>
                                    <option value="electronics" {{ old('store_category') == 'electronics' ? 'selected' : '' }}>📱 إلكترونيات</option>
                                    <option value="clothes" {{ old('store_category') == 'clothes' ? 'selected' : '' }}>👗 ملابس</option>
                                    <option value="home" {{ old('store_category') == 'home' ? 'selected' : '' }}>🛋️ أدوات منزلية</option>
                                    <option value="grocery" {{ old('store_category') == 'grocery' ? 'selected' : '' }}>🛒 بقالة</option>
                                    <option value="cars" {{ old('store_category') == 'cars' ? 'selected' : '' }}>🚗 سيارات</option>
                                    <option value="real_estate" {{ old('store_category') == 'real_estate' ? 'selected' : '' }}>🏠 عقارات</option>
                                    <option value="cleaning" {{ old('store_category') == 'cleaning' ? 'selected' : '' }}>🧹 ورشة تنظيف</option>
                                    <option value="other" {{ old('store_category') == 'other' ? 'selected' : '' }}>📌 أخرى</option>
                                </select>
                                @error('store_category')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" style="color: var(--text-primary);">وصف المتجر *</label>
                                <textarea name="store_description" class="form-control form-rizk" rows="3">{{ old('store_description') }}</textarea>
                                @error('store_description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- حقول مقدم الخدمات -->
                    <div id="serviceProviderFields" style="display: {{ old('user_type') == 'service_provider' ? 'block' : 'none' }};">
                        <div class="card-rizk p-3 mb-3" style="background: var(--bg-card); border: 1px solid rgba(212, 175, 55, 0.1);">
                            <h6 style="color: var(--text-primary);">🛎️ نوع الخدمة</h6>
                            <div class="mb-3">
                                <label class="form-label" style="color: var(--text-primary);">اختر نوع الخدمة *</label>
                                <select name="service_type" id="serviceType" class="form-select form-rizk">
                                    <option value="">اختر نوع الخدمة</option>
                                    <optgroup label="🧹 خدمات التنظيف">
                                        <option value="cleaning_company" {{ old('service_type') == 'cleaning_company' ? 'selected' : '' }}>🧹 ورشة تنظيف</option>
                                        <option value="cleaner" {{ old('service_type') == 'cleaner' ? 'selected' : '' }}>🧹 عامل نظافة</option>
                                        <option value="carpet_cleaner" {{ old('service_type') == 'carpet_cleaner' ? 'selected' : '' }}>🧹 تنظيف سجاد</option>
                                    </optgroup>
                                    <optgroup label="🍳 خدمات منزلية">
                                        <option value="cooking" {{ old('service_type') == 'cooking' ? 'selected' : '' }}>🍳 طبخ منزلي</option>
                                        <option value="vegetables" {{ old('service_type') == 'vegetables' ? 'selected' : '' }}>🥬 تجهيز خضار</option>
                                        <option value="gardener" {{ old('service_type') == 'gardener' ? 'selected' : '' }}>🌱 بستاني</option>
                                        <option value="tailor" {{ old('service_type') == 'tailor' ? 'selected' : '' }}>🧵 خياط</option>
                                        <option value="hairdresser" {{ old('service_type') == 'hairdresser' ? 'selected' : '' }}>💇 حلاق</option>
                                    </optgroup>
                                    <optgroup label="🔧 خدمات فنية">
                                        <option value="technician" {{ old('service_type') == 'technician' ? 'selected' : '' }}>🔧 فني</option>
                                        <option value="electrician" {{ old('service_type') == 'electrician' ? 'selected' : '' }}>⚡ كهربائي</option>
                                        <option value="plumber" {{ old('service_type') == 'plumber' ? 'selected' : '' }}>🔧 سباك</option>
                                        <option value="carpenter" {{ old('service_type') == 'carpenter' ? 'selected' : '' }}>🪚 نجار</option>
                                        <option value="painter" {{ old('service_type') == 'painter' ? 'selected' : '' }}>🎨 دهان</option>
                                        <option value="mechanic" {{ old('service_type') == 'mechanic' ? 'selected' : '' }}>🔧 ميكانيكي</option>
                                    </optgroup>
                                    <optgroup label="💻 خدمات تقنية">
                                        <option value="programmer" {{ old('service_type') == 'programmer' ? 'selected' : '' }}>💻 مبرمج</option>
                                        <option value="designer" {{ old('service_type') == 'designer' ? 'selected' : '' }}>🎨 مصمم جرافيك</option>
                                        <option value="photographer" {{ old('service_type') == 'photographer' ? 'selected' : '' }}>📸 مصور</option>
                                        <option value="translator" {{ old('service_type') == 'translator' ? 'selected' : '' }}>🌐 مترجم</option>
                                    </optgroup>
                                    <optgroup label="👨‍🏫 خدمات تعليمية">
                                        <option value="tutor" {{ old('service_type') == 'tutor' ? 'selected' : '' }}>📚 مدرس خصوصي</option>
                                        <option value="teacher" {{ old('service_type') == 'teacher' ? 'selected' : '' }}>👨‍🏫 معلم</option>
                                    </optgroup>
                                    <optgroup label="🚗 خدمات نقل">
                                        <option value="transport" {{ old('service_type') == 'transport' ? 'selected' : '' }}>🚚 سيارة نقل</option>
                                        <option value="driver" {{ old('service_type') == 'driver' ? 'selected' : '' }}>🚗 سائق</option>
                                    </optgroup>
                                    <optgroup label="👷 خدمات عمالية">
                                        <option value="worker" {{ old('service_type') == 'worker' ? 'selected' : '' }}>👷 عامل</option>
                                        <option value="security" {{ old('service_type') == 'security' ? 'selected' : '' }}>🛡️ حارس أمن</option>
                                    </optgroup>
                                    <optgroup label="👨‍⚕️ خدمات صحية">
                                        <option value="nurse" {{ old('service_type') == 'nurse' ? 'selected' : '' }}>👩‍⚕️ ممرض</option>
                                    </optgroup>
                                    <optgroup label="👨‍💼 خدمات مهنية">
                                        <option value="engineer" {{ old('service_type') == 'engineer' ? 'selected' : '' }}>👨‍💻 مهندس</option>
                                        <option value="architect" {{ old('service_type') == 'architect' ? 'selected' : '' }}>🏛️ مهندس معماري</option>
                                        <option value="accountant" {{ old('service_type') == 'accountant' ? 'selected' : '' }}>🧾 محاسب</option>
                                        <option value="lawyer" {{ old('service_type') == 'lawyer' ? 'selected' : '' }}>⚖️ محامي</option>
                                        <option value="consultant" {{ old('service_type') == 'consultant' ? 'selected' : '' }}>💼 استشاري</option>
                                    </optgroup>
                                    <optgroup label="📌 أخرى">
                                        <option value="other" {{ old('service_type') == 'other' ? 'selected' : '' }}>📌 أخرى (يرجى التوضيح في الوصف)</option>
                                    </optgroup>
                                </select>
                                @error('service_type')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label" style="color: var(--text-primary);">وصف الخدمة</label>
                                <textarea name="service_description" class="form-control form-rizk" rows="3" placeholder="وصف الخدمة التي تقدمها">{{ old('service_description') }}</textarea>
                                @error('service_description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary);">كلمة المرور *</label>
                        <input type="password" name="password" class="form-control form-rizk" required>
                        <small style="color: var(--text-muted);">يجب أن تحتوي كلمة المرور على الأقل على 8 أحرف، حرف كبير، حرف صغير، ورقم</small>
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" style="color: var(--text-primary);">تأكيد كلمة المرور *</label>
                        <input type="password" name="password_confirmation" class="form-control form-rizk" required>
                        @error('password_confirmation')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-rizk-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>إنشاء الحساب
                        </button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <p style="color: var(--text-muted);">لديك حساب بالفعل؟ 
                            <a href="{{ route('login') }}" style="color: var(--primary-color);">سجل الدخول</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userType = document.getElementById('userType');
        const merchantFields = document.getElementById('merchantFields');
        const serviceProviderFields = document.getElementById('serviceProviderFields');
        
        function toggleFields() {
            merchantFields.style.display = 'none';
            serviceProviderFields.style.display = 'none';
            
            merchantFields.querySelectorAll('input, select, textarea').forEach(el => el.removeAttribute('required'));
            serviceProviderFields.querySelectorAll('input, select, textarea').forEach(el => el.removeAttribute('required'));
            
            if (userType.value === 'merchant') {
                merchantFields.style.display = 'block';
                merchantFields.querySelectorAll('input, select, textarea').forEach(el => el.setAttribute('required', 'required'));
            } else if (userType.value === 'service_provider') {
                serviceProviderFields.style.display = 'block';
                serviceProviderFields.querySelectorAll('input, select, textarea').forEach(el => el.setAttribute('required', 'required'));
            }
        }
        
        userType.addEventListener('change', toggleFields);
        toggleFields();
    });
</script>
@endsection
