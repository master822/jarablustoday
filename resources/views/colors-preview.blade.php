@extends('layouts.app')

@section('title', 'معاينة الألوان والثيمات')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">🎨 معاينة الألوان والثيمات والأنيميشن</h1>
    
    <!-- الألوان الأساسية -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">الألوان الأساسية (Light Mode)</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #6366f1; color: white; text-align: center;">#6366f1<br>Primary</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #8b5cf6; color: white; text-align: center;">#8b5cf6<br>Secondary</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #22c55e; color: white; text-align: center;">#22c55e<br>Success</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #ef4444; color: white; text-align: center;">#ef4444<br>Danger</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #f59e0b; color: white; text-align: center;">#f59e0b<br>Warning</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #06b6d4; color: white; text-align: center;">#06b6d4<br>Info</div>
                </div>
            </div>
        </div>
    </div>

    <!-- الألوان في الوضع المظلم -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">الألوان في الوضع المظلم (Dark Mode)</h5>
        </div>
        <div class="card-body" style="background: #1a202c;">
            <div class="row g-3">
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #4f46e5; color: white; text-align: center;">#4f46e5<br>Primary</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #7c3aed; color: white; text-align: center;">#7c3aed<br>Secondary</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #16a34a; color: white; text-align: center;">#16a34a<br>Success</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #dc2626; color: white; text-align: center;">#dc2626<br>Danger</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #d97706; color: white; text-align: center;">#d97706<br>Warning</div>
                </div>
                <div class="col-md-2">
                    <div class="p-3 rounded" style="background: #0891b2; color: white; text-align: center;">#0891b2<br>Info</div>
                </div>
            </div>
        </div>
    </div>

    <!-- ألوان النصوص والخلفيات -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">ألوان النصوص والخلفيات</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="p-3" style="background: #ffffff; border: 1px solid #ddd;">
                        <p style="color: #000000;">نص أسود (#000000)</p>
                        <p style="color: #333333;">نص رمادي غامق (#333333)</p>
                        <p style="color: #666666;">نص رمادي (#666666)</p>
                        <p style="color: #999999;">نص رمادي فاتح (#999999)</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3" style="background: #1a202c; border: 1px solid #ddd;">
                        <p style="color: #ffffff;">نص أبيض (#ffffff)</p>
                        <p style="color: #e2e8f0;">نص فاتح (#e2e8f0)</p>
                        <p style="color: #a0aec0;">نص رمادي مائل (#a0aec0)</p>
                        <p style="color: #718096;">نص رمادي غامق مائل (#718096)</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3" style="background: #f8f9fa; border: 1px solid #ddd;">
                        <p class="text-primary">نص Primary</p>
                        <p class="text-success">نص Success</p>
                        <p class="text-danger">نص Danger</p>
                        <p class="text-warning">نص Warning</p>
                        <p class="text-info">نص Info</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3" style="background: #2d3748; border: 1px solid #ddd;">
                        <p class="text-primary" style="color: #4f46e5;">نص Primary</p>
                        <p class="text-success" style="color: #16a34a;">نص Success</p>
                        <p class="text-danger" style="color: #dc2626;">نص Danger</p>
                        <p class="text-warning" style="color: #d97706;">نص Warning</p>
                        <p class="text-info" style="color: #0891b2;">نص Info</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الأنيميشن والتأثيرات -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">الأنيميشن والتأثيرات</h5>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-3 text-center">
                    <div class="p-3 bg-primary text-white rounded animated-card" style="animation: fadeIn 0.5s;">
                        <i class="fas fa-heart fa-2x mb-2"></i>
                        <p>fadeIn</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-3 bg-success text-white rounded" style="transition: all 0.3s ease; transform: scale(1);">
                        <i class="fas fa-star fa-2x mb-2"></i>
                        <p>hover: scale</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-3 bg-warning text-dark rounded" style="transition: all 0.3s ease;">
                        <i class="fas fa-gem fa-2x mb-2"></i>
                        <p>hover: shadow</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-3 bg-danger text-white rounded" style="animation: pulse 2s infinite;">
                        <i class="fas fa-bolt fa-2x mb-2"></i>
                        <p>pulse</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-2">
                <div class="col-md-3 text-center">
                    <div class="p-3 bg-secondary text-white rounded" style="animation: slideIn 0.5s;">
                        <i class="fas fa-arrow-right fa-2x mb-2"></i>
                        <p>slideIn</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-3 bg-info text-white rounded" style="animation: bounce 1s ease infinite;">
                        <i class="fas fa-rocket fa-2x mb-2"></i>
                        <p>bounce</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-3 bg-dark text-white rounded" style="transition: all 0.5s ease;">
                        <i class="fas fa-spinner fa-2x mb-2"></i>
                        <p>spin (hover)</p>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="p-3" style="background: linear-gradient(45deg, #6366f1, #8b5cf6); color: white; border-radius: 10px;">
                        <i class="fas fa-palette fa-2x mb-2"></i>
                        <p>gradient</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- مشاكل الألوان في الوضع الفاتح -->
    <div class="card shadow-sm mb-4 border-danger">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">⚠️ مشاكل الألوان في الوضع الفاتح</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 border rounded" style="background: #f8f9fa;">
                        <p class="text-muted">نص رمادي فاتح على خلفية فاتحة (غير واضح)</p>
                        <p style="color: #999999;">نص بلون #999999 على خلفية فاتحة</p>
                        <p style="color: #cccccc;">نص بلون #cccccc على خلفية فاتحة</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded" style="background: #ffffff;">
                        <p style="color: #e2e8f0;">نص #e2e8f0 على خلفية بيضاء</p>
                        <p style="color: #a0aec0;">نص #a0aec0 على خلفية بيضاء</p>
                        <p class="text-secondary">نص secondary على خلفية بيضاء</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded" style="background: #ffffff;">
                        <p style="color: #718096;">نص #718096 على خلفية بيضاء (مقبول)</p>
                        <p style="color: #4a5568;">نص #4a5568 على خلفية بيضاء (جيد)</p>
                        <p style="color: #2d3748;">نص #2d3748 على خلفية بيضاء (ممتاز)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- البوتونات والأزرار -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">تصميم الأزرار</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <button class="btn btn-primary w-100">Primary</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success w-100">Success</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-danger w-100">Danger</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-warning w-100">Warning</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-info w-100 text-white">Info</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-secondary w-100">Secondary</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-dark w-100 text-white">Dark</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-light w-100 border">Light</button>
                </div>
            </div>
            <div class="row g-3 mt-2">
                <div class="col-md-3">
                    <button class="btn btn-outline-primary w-100">Outline Primary</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-success w-100">Outline Success</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-danger w-100">Outline Danger</button>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-warning w-100">Outline Warning</button>
                </div>
            </div>
        </div>
    </div>

    <!-- البطاقات والكرتات -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">تصميم البطاقات</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">بطاقة بظل خفيف</h5>
                            <p class="card-text text-muted">نص في بطاقة مع ظل خفيف</p>
                            <button class="btn btn-sm btn-primary">زر</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title">بطاقة بظل كبير</h5>
                            <p class="card-text text-muted">نص في بطاقة مع ظل كبير</p>
                            <button class="btn btn-sm btn-success">زر</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" style="border: 2px solid #6366f1;">
                        <div class="card-body">
                            <h5 class="card-title">بطاقة بحدود</h5>
                            <p class="card-text text-muted">نص في بطاقة مع حدود مميزة</p>
                            <button class="btn btn-sm btn-outline-primary">زر</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- النماذج والحقول -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">تصميم النماذج</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">حقل نص عادي</label>
                    <input type="text" class="form-control" placeholder="نص عادي" value="نص تجريبي">
                </div>
                <div class="col-md-6">
                    <label class="form-label">حقل مع border</label>
                    <input type="text" class="form-control border-primary" placeholder="نص مع حدود" value="نص تجريبي">
                </div>
                <div class="col-md-6">
                    <label class="form-label">حقل مع bg</label>
                    <input type="text" class="form-control bg-light" placeholder="خلفية فاتحة" value="نص تجريبي">
                </div>
                <div class="col-md-6">
                    <label class="form-label">حقل مع shadow</label>
                    <input type="text" class="form-control shadow-sm" placeholder="مع ظل" value="نص تجريبي">
                </div>
            </div>
        </div>
    </div>

    <!-- استايلات إضافية -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white;">
            <h5 class="mb-0">استايلات إضافية</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 rounded" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                        <h6>Gradient 1</h6>
                        <p class="small">#f093fb → #f5576c</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                        <h6>Gradient 2</h6>
                        <p class="small">#4facfe → #00f2fe</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 rounded" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: #1a202c;">
                        <h6>Gradient 3</h6>
                        <p class="small">#43e97b → #38f9d7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS للأنيميشن -->
<style>
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes slideIn {
        from { transform: translateX(-20px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    
    .animated-card:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
    .bg-gradient {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
    }
    
    /* تنسيقات للوضع المظلم */
    .dark-mode .card {
        background-color: #2d3748;
        color: #e2e8f0;
        border-color: #4a5568;
    }
    .dark-mode .text-muted {
        color: #a0aec0 !important;
    }
    .dark-mode .bg-light {
        background-color: #4a5568 !important;
        color: #e2e8f0 !important;
    }
    .dark-mode .border {
        border-color: #4a5568 !important;
    }
    .dark-mode .form-control {
        background-color: #4a5568;
        border-color: #718096;
        color: #e2e8f0;
    }
    .dark-mode .form-control::placeholder {
        color: #a0aec0;
    }
</style>
@endsection
