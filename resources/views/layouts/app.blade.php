<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rizk - رزق')</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* ===== إصلاح حجم الموقع ===== */
html, body {
    overflow-x: hidden;
    width: 100%;
    max-width: 100%;
}

.btn-like {
    background: transparent;
    border: none;
    cursor: pointer;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 5px 10px;
    border-radius: 20px;
    color: #94a3b8;
}

.btn-like .fa-heart {
    transition: all 0.3s ease;
}

.btn-like.liked {
    color: #ef4444;
}

.btn-like.liked .fa-heart {
    animation: heartBeat 0.3s ease;
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
}

.btn-like:hover {
    background: rgba(239, 68, 68, 0.1);
}

.btn-like .likes-count {
    font-size: 0.8rem;
    font-weight: 600;
}

.container {
    width: 100%;
    max-width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}

@media (min-width: 576px) {
    .container { max-width: 540px; }
}
@media (min-width: 768px) {
    .container { max-width: 720px; }
}
@media (min-width: 992px) {
    .container { max-width: 960px; }
}
@media (min-width: 1200px) {
    .container { max-width: 1140px; }
}
@media (min-width: 1400px) {
    .container { max-width: 1320px; }
}

/* ===== تحسين عرض الجداول ===== */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

/* ===== تحسين عرض البطاقات ===== */
.row {
    margin-right: -10px;
    margin-left: -10px;
}
.row > * {
    padding-right: 10px;
    padding-left: 10px;
}

/* ===== تحسين النافبار ===== */
.navbar-rizk .container {
    max-width: 100%;
    padding: 0 15px;
}

/* ===== تحسين الفوتر ===== */
.footer-rizk .container {
    max-width: 100%;
    padding: 0 15px;
}
/* ===== تحسين الاستجابة العامة ===== */
img, video, iframe {
    max-width: 100%;
    height: auto;
}

/* منع التمرير الأفقي */
* {
    max-width: 100%;
    box-sizing: border-box;
}

/* تحسين عرض العناصر في الشاشات الصغيرة */
@media (max-width: 576px) {
    .card-rizk .card-body {
        padding: 12px !important;
    }
    .btn {
        font-size: 0.8rem !important;
        padding: 6px 12px !important;
    }
    .section-title-rizk {
        font-size: 1.1rem !important;
    }
    h1, h2, h3 {
        font-size: 1.2rem !important;
    }
    .display-4 {
        font-size: 1.8rem !important;
    }
    .display-5 {
        font-size: 1.5rem !important;
    }
}
        :root {
            --primary-color: #d4af37;
            --primary-dark: #b8960f;
            --primary-light: #f0d060;
            --secondary-color: #8b5cf6;
            --secondary-dark: #6d28d9;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #94a3b8;
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --bg-navbar: rgba(255, 255, 255, 0.92);
            --bg-footer: #0f172a;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.12);
            --shadow-xl: 0 20px 50px rgba(0,0,0,0.15);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --brightness: 1;
        }
        
        [data-theme="dark"] {
            --primary-color: #f0d060;
            --primary-dark: #d4af37;
            --primary-light: #f7e27a;
            --secondary-color: #a78bfa;
            --secondary-dark: #8b5cf6;
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-navbar: rgba(15, 23, 42, 0.95);
            --bg-footer: #020617;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.3);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.4);
            --shadow-lg: 0 8px 30px rgba(0,0,0,0.5);
            --shadow-xl: 0 20px 50px rgba(0,0,0,0.6);
        }
        
        body {
            filter: brightness(var(--brightness));
            transition: filter 0.2s ease, background-color 0.3s ease, color 0.3s ease;
            font-size: 15px;
            line-height: 1.7;
            background-color: var(--bg-body);
            color: var(--text-primary);
            padding-top: 80px;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        * { box-sizing: border-box; }
        
        a { color: var(--primary-color); text-decoration: none; transition: color 0.3s ease; }
        a:hover { color: var(--primary-dark); }
        
        .navbar-rizk {
            background: var(--bg-navbar) !important;
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(212, 175, 55, 0.2);
            box-shadow: var(--shadow-sm);
            padding: 10px 0;
            transition: all 0.4s ease;
        }
        
        .navbar-rizk .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--text-primary) !important;
        }
        
        .navbar-rizk .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.3rem;
            animation: float 4s ease-in-out infinite;
            box-shadow: 0 4px 15px rgba(212, 175, 55, 0.3);
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }
        
        .navbar-rizk .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
        }
        
        .navbar-rizk .nav-link:hover {
            color: var(--primary-color) !important;
            background: rgba(212, 175, 55, 0.06);
        }
        
        .navbar-rizk .dropdown-menu {
            background: var(--bg-card);
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius-md);
            padding: 8px;
            min-width: 220px;
            border: 1px solid rgba(212, 175, 55, 0.08);
            margin-top: 8px;
        }
        
        .navbar-rizk .dropdown-item {
            color: var(--text-secondary);
            border-radius: var(--radius-sm);
            padding: 10px 16px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .navbar-rizk .dropdown-item:hover {
            background: rgba(212, 175, 55, 0.08);
            color: var(--primary-color);
        }
        
        .card-rizk {
            background: var(--bg-card);
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            height: 100%;
        }
        
        .card-rizk:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-8px);
        }
        
        .btn-rizk-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: var(--radius-md);
            font-weight: 700;
            transition: all 0.3s ease;
        }
        
        .btn-rizk-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .btn-rizk-outline {
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            padding: 8px 22px;
            border-radius: var(--radius-md);
            font-weight: 700;
            transition: all 0.3s ease;
        }
        
        .btn-rizk-outline:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .footer-rizk {
            background: var(--bg-footer);
            color: #94a3b8;
            padding: 50px 0 25px;
            margin-top: 50px;
            border-top: 3px solid var(--primary-color);
        }
        
        .section-title-rizk {
            position: relative;
            padding-bottom: 14px;
            margin-bottom: 30px;
            font-weight: 800;
        }
        
        .section-title-rizk::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 70px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 4px;
        }
        
        .gold-text { color: var(--primary-color); }
        
        .brightness-container {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px;
            background: var(--bg-card);
            border-radius: 30px;
            box-shadow: var(--shadow-sm);
            border: 2px solid rgba(212, 175, 55, 0.15);
            min-width: 200px;
            transition: all 0.3s ease;
        }
        
        .brightness-slider {
            -webkit-appearance: none;
            appearance: none;
            width: 120px;
            height: 6px;
            border-radius: 10px;
            background: linear-gradient(to right, #fbbf24, #f59e0b, #818cf8, #1e293b);
            outline: none;
            cursor: pointer;
        }
        
        .brightness-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(212, 175, 55, 0.4);
            border: 2px solid white;
        }
        
        .brightness-value {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-primary);
            min-width: 38px;
            text-align: center;
        }
        
        .pagination-simple {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 16px;
            margin-top: 30px;
            padding: 20px 0;
        }
        
        .pagination-simple .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 28px;
            border-radius: var(--radius-md);
            border: 2px solid var(--primary-color);
            background: var(--bg-card);
            color: var(--text-primary);
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            text-decoration: none;
            min-width: 140px;
        }
        
        .pagination-simple .page-btn:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .pagination-simple .page-btn.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            pointer-events: none;
        }
        
        .pagination-simple .page-info {
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.9rem;
        }
        
/* ===== تحسينات الاستجابة ===== */
@media (max-width: 1200px) {
    .container { max-width: 95%; }
}

@media (max-width: 992px) {
    body { padding-top: 72px; font-size: 14px; }
    .navbar-rizk .navbar-brand { font-size: 1.3rem; }
    .navbar-rizk .brand-icon { width: 36px; height: 36px; font-size: 1rem; }
    .brightness-slider { width: 80px; }
    .brightness-container { min-width: 160px; }
    .product-card .product-title { font-size: 0.9rem; }
    .product-card .product-price { font-size: 1rem; }
}

@media (max-width: 768px) {
    body { padding-top: 64px; font-size: 13px; }
    .navbar-rizk { padding: 8px 0; }
    .navbar-rizk .navbar-brand { font-size: 1.1rem; }
    .navbar-rizk .brand-icon { width: 32px; height: 32px; font-size: 0.9rem; }
    .navbar-rizk .brand-sub { font-size: 0.55rem; }
    .navbar-rizk .nav-link { padding: 6px 12px; font-size: 0.85rem; }
    .btn-rizk { padding: 8px 16px; font-size: 0.85rem; }
    .card-rizk .card-body { padding: 14px; }
    .section-title-rizk { font-size: 1.2rem; }
    .footer-rizk { padding: 30px 0 15px; }
    .brightness-slider { width: 60px; }
    .brightness-container { min-width: 140px; padding: 4px 10px; }
    .brightness-value { font-size: 0.7rem; min-width: 30px; }
    .brightness-container .icon-wrapper { width: 24px; height: 24px; }
    .brightness-container .mode-icon { font-size: 0.9rem; }
    
    /* تحسين عرض المنتجات */
    .product-grid .col-lg-3 { flex: 0 0 50%; max-width: 50%; }
    .product-card .product-description { font-size: 0.75rem; }
    .pagination-simple .page-btn { padding: 8px 16px; min-width: 80px; font-size: 0.8rem; }
}

@media (max-width: 576px) {
    body { padding-top: 56px; font-size: 12px; }
    .container { padding-left: 10px; padding-right: 10px; }
    .brightness-slider { width: 50px; }
    .brightness-container { min-width: 120px; padding: 3px 6px; gap: 6px; }
    .brightness-value { font-size: 0.65rem; min-width: 26px; }
    
    /* تحسين عرض المنتجات في الشاشات الصغيرة */
    .product-grid .col-6 { flex: 0 0 50%; max-width: 50%; }
    .product-card .product-title { font-size: 0.8rem; }
    .product-card .product-price { font-size: 0.9rem; }
    .product-card .product-meta { font-size: 0.6rem; }
    .product-actions .btn-sm { font-size: 0.65rem; padding: 4px 6px; }
    
    .pagination-simple .page-btn { padding: 6px 12px; min-width: 60px; font-size: 0.7rem; gap: 4px; }
    .pagination-simple .page-info { font-size: 0.7rem; }
}
    </style>

<script>
    // إغلاق القائمة الجانبية تلقائياً عند النقر خارجها
    document.addEventListener('DOMContentLoaded', function() {
        var navbarCollapse = document.getElementById('navbarNav');
        var toggler = document.querySelector('.navbar-toggler');
        
        if (navbarCollapse && toggler) {
            // إغلاق القائمة عند النقر في أي مكان خارجها
            document.addEventListener('click', function(event) {
                var isClickInside = navbarCollapse.contains(event.target) || toggler.contains(event.target);
                if (!isClickInside && navbarCollapse.classList.contains('show')) {
                    toggler.click();
                }
            });
        }
    });
</script>
</head>
<body>
    <!-- النافبار -->
    <nav class="navbar navbar-expand-lg navbar-rizk fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
    @if(session('site_logo'))
        <img src="{{ asset('storage/' . session('site_logo')) }}" 
             alt="Rizk" 
             style="height: 45px; width: auto; max-width: 150px; object-fit: contain;">
    @else
        <!-- <div class="brand-icon"><i class="fas fa-gem"></i></div> -->
        <div>
            <span style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark), var(--primary-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Rizk</span>
           <!-- <span style="font-size: 0.65rem; font-weight: 400; color: var(--text-muted); display: block; margin-top: -4px;">رزق</span> -->
        </div>
    @endif
</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/products') }}">المنتجات</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/merchants') }}">المتاجر</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/discounts') }}">التخفيضات</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/used-products') }}"> المستعمل</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/services') }}">خدمات</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/jobs') }}">فرص العمل</a></li>
                </ul>
                
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <!-- شريط السطوع -->
                    <li class="nav-item">
                        <div class="brightness-container">
                            <i class="fas fa-sun" style="color: #fbbf24;"></i>
                            <input type="range" min="0" max="100" value="50" class="brightness-slider" id="brightnessSlider">
                            <span class="brightness-value" id="brightnessValue">50%</span>
                        </div>
                    </li>
                    
                    <!-- بحث -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-search"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" style="min-width: 350px; padding: 16px;">
                            <li>
                                <form action="{{ route('search.products') }}" method="GET">
                                    <div class="mb-2">
                                        <input type="text" name="q" class="form-control form-rizk" placeholder="ابحث عن منتج..." value="{{ request('q') }}">
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <input type="number" name="min_price" class="form-control form-rizk" placeholder="السعر من" value="{{ request('min_price') }}">
                                        </div>
                                        <div class="col-6">
                                            <input type="number" name="max_price" class="form-control form-rizk" placeholder="السعر إلى" value="{{ request('max_price') }}">
                                        </div>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6">
                                            <select name="condition" class="form-select form-rizk">
                                                <option value="">الحالة</option>
                                                <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>جديد</option>
                                                <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>مستعمل</option>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <select name="sort" class="form-select form-rizk">
                                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>الأحدث</option>
                                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر: منخفض</option>
                                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر: مرتفع</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-rizk-primary w-100">
                                        <i class="fas fa-search me-2"></i>بحث
                                    </button>
                                </form>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <div class="d-grid gap-1">
                                    <a href="{{ route('search.products') }}" class="btn btn-sm btn-rizk-outline">بحث في المنتجات</a>
                                    <a href="{{ route('search.merchants') }}" class="btn btn-sm btn-rizk-outline">بحث في المتاجر</a>
                                    <a href="{{ route('search.discounts') }}" class="btn btn-sm btn-rizk-outline">بحث في التخفيضات</a>
                                    <a href="{{ route('search.used-products') }}" class="btn btn-sm btn-rizk-outline">بحث في المستعمل</a>
                                    <a href="{{ route('search.services') }}" class="btn btn-sm btn-rizk-outline">بحث في الخدمات</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    
                    @auth
                        @php
                            $unreadMessages = \App\Models\Message::where('receiver_id', Auth::id())->where('is_read', false)->count();
                            $unreadNotifications = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->count();
                            $latestNotifications = \App\Models\Notification::where('user_id', Auth::id())->where('is_read', false)->with('sender')->orderBy('created_at', 'desc')->limit(5)->get();
                        @endphp

                        <!-- الإشعارات -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell"></i>
                                @if($unreadNotifications > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 0.6rem; border-radius: 50%; padding: 2px 6px;">
                                        {{ $unreadNotifications }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="min-width: 350px; max-height: 400px; overflow-y: auto;">
                                <li class="dropdown-header d-flex justify-content-between align-items-center">
                                    <span>الإشعارات</span>
                                    @if($unreadNotifications > 0)
                                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-rizk-outline">تحديد الكل كمقروء</button>
                                        </form>
                                    @endif
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                
                                @if($latestNotifications->count() > 0)
                                    @foreach($latestNotifications as $notification)
                                        <li>
                                            <a class="dropdown-item {{ !$notification->is_read ? 'bg-gold-gradient bg-opacity-10' : '' }}" 
                                               href="{{ $notification->link ?? '#' }}">
                                                <div class="d-flex align-items-start gap-2">
                                                    <div>
                                                        <strong>{{ $notification->title }}</strong>
                                                        <p class="small text-muted mb-0">{{ Str::limit($notification->message, 50) }}</p>
                                                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    @if(!$notification->is_read)
                                                        <span class="badge bg-primary ms-auto" style="font-size: 0.5rem;">جديد</span>
                                                    @endif
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-center" href="{{ route('notifications.index') }}">عرض جميع الإشعارات</a></li>
                                @else
                                    <li class="text-center py-3">
                                        <i class="fas fa-bell-slash text-muted mb-2"></i>
                                        <p class="text-muted mb-0">لا توجد إشعارات</p>
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <!-- الرسائل -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle position-relative" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-envelope"></i>
                                @if($unreadMessages > 0)
                                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="font-size: 0.6rem; border-radius: 50%; padding: 2px 6px;">
                                        {{ $unreadMessages }}
                                    </span>
                                @endif
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('messages.inbox') }}">
                                    <i class="fas fa-inbox me-2"></i>الوارد 
                                    @if($unreadMessages > 0)
                                        <span class="badge bg-danger">{{ $unreadMessages }}</span>
                                    @endif
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('messages.sent') }}">
                                    <i class="fas fa-paper-plane me-2"></i>المرسلة
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('messages.inbox') }}">
                                    <i class="fas fa-comments me-2"></i>جميع المحادثات
                                </a></li>
                            </ul>
                        </li>

                        <!-- لوحة التحكم حسب نوع ادمن -->
@if(auth()->user()->user_type === 'admin')
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            <i class="fas fa-shield-alt me-1"></i>لوحة المسؤول
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.users') }}">المستخدمين</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.subscriptions') }}">الاشتراكات</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.payments') }}">طلبات الدفع</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.products') }}">المنتجات</a></li>
            <li><a class="dropdown-item" href="{{ route('admin.statistics') }}">الإحصائيات</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">الملف الشخصي</a></li>
        </ul>
    </li>
@endif

                        <!-- لوحة التحكم حسب نوع المستخدم -->
                        @if(auth()->user()->user_type === 'merchant')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-crown me-1"></i>لوحة التاجر
                                </a>
                                <ul class="dropdown-menu">

                                    <li><a class="dropdown-item" href="{{ route('merchant.dashboard') }}">لوحة التحكم</a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.products') }}">منتجاتي</a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.discounts') }}">تخفيضاتي</a></li>
                                    <li><a class="dropdown-item" href="{{ route('subscription.plans') }}"><i class="fas fa-crown me-2"></i>باقاتي</a></li>
                                    <li><a class="dropdown-item" href="{{ route('merchant.jobs') }}">فرص العمل</a></li>
                                </ul>
                            </li>
                        @endif

                        @if(auth()->user()->user_type === "service_provider" || auth()->user()->user_type === "other")
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-concierge-bell me-1"></i>لوحة الخدمات
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('service-provider.dashboard') }}">لوحة التحكم</a></li>
                                    <li><a class="dropdown-item" href="{{ route('service-provider.services') }}">خدماتي</a></li>
                                    <li><a class="dropdown-item" href="{{ route('service-provider.jobs') }}">فرص العمل</a></li>
                                </ul>
                            </li>
                        @endif

                        @if(auth()->user()->user_type === 'user')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user me-1"></i>حسابي
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">لوحتي</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.products') }}">منتجاتي المستعملة</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.products.create') }}">إضافة منتج مستعمل</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.messages') }}">الرسائل</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.profile') }}">الملف الشخصي</a></li>
                                </ul>
                            </li>
                        @endif

                        <!-- تسجيل الخروج -->
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">
                                    <i class="fas fa-sign-out-alt me-1"></i>تسجيل خروج
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a></li>
                        <li class="nav-item"><a class="btn btn-rizk-primary" href="{{ route('register') }}">إنشاء حساب</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- رسائل التنبيه -->
    <div class="container mt-2">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show py-2">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>
    
    <!-- المحتوى -->
    <main>@yield('content')</main>
    
    <!-- الفوتر -->
    <footer class="footer-rizk">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
    @if(session('site_logo'))
        <img src="{{ asset('storage/' . session('site_logo')) }}" 
             alt="Rizk" 
             style="height: 55px; width: auto; max-width: 180px; object-fit: contain; margin-bottom: 10px;">
    @else
        <h5 style="color: #fff;">Rizk</h5>
    @endif
    <p class="small">منصة شاملة لبيع وشراء المنتجات الجديدة والمستعملة مع أفضل العروض والتخفيضات</p>
</div>
                <div class="col-lg-2">
                    <h6>روابط سريعة</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('about') }}">عن الموقع</a></li>
                        <li><a href="{{ route('contact') }}">اتصل بنا</a></li>
                        <li><a href="{{ route('privacy') }}">الخصوصية</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6>الأقسام</h6>
                    <ul class="list-unstyled small">
                        <li><a href="{{ url('/products') }}">المنتجات</a></li>
                        <li><a href="{{ url('/merchants') }}">المتاجر</a></li>
                        <li><a href="{{ url('/discounts') }}">التخفيضات</a></li>
                        <li><a href="{{ url('/used-products') }}">المستعمل</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6>معلومات الاتصال</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-phone gold-text me-2"></i> +90 555 123 4567</li>
                        <li><i class="fas fa-envelope gold-text me-2"></i> info@rizk.com</li>
                        <li><i class="fas fa-map-marker-alt gold-text me-2"></i> اسطنبول، تركيا</li>
                    </ul>
                </div>
            </div>
            <hr class="my-3" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center small">&copy; {{ date('Y') }} Rizk - جميع الحقوق محفوظة</div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
// ===== نظام الإعجابات =====
// ===== نظام الإعجابات =====
function toggleLike(productId, element) {
    @if(!Auth::check())
        alert('يجب تسجيل الدخول أولاً للإعجاب بالمنتج');
        return;
    @endif
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
    
    // تغيير لون الزر فوراً لإعطاء رد فعل سريع
    const isCurrentlyLiked = element.classList.contains('liked');
    if (isCurrentlyLiked) {
        element.classList.remove('liked');
        element.style.color = '#94a3b8';
    } else {
        element.classList.add('liked');
        element.style.color = '#ef4444';
    }
    
    fetch(`/products/${productId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const isLiked = data.is_liked;
            const likesCount = data.likes_count;
            
            // تحديث عدد الإعجابات في الزر
            const countSpan = element.querySelector('.likes-count');
            if (countSpan) {
                countSpan.textContent = likesCount;
            }
            
            // تحديث عدد الإعجابات في الأعلى (في صفحة العرض)
            const displayCount = document.getElementById('likes-count-display');
            if (displayCount) {
                displayCount.textContent = likesCount;
            }
            
            // تحديث حالة الزر بناءً على الاستجابة من السيرفر
            if (isLiked) {
                element.classList.add('liked');
                element.style.color = '#ef4444';
            } else {
                element.classList.remove('liked');
                element.style.color = '#94a3b8';
            }
        } else {
            // في حالة الخطأ، نرجع الحالة السابقة
            if (isCurrentlyLiked) {
                element.classList.add('liked');
                element.style.color = '#ef4444';
            } else {
                element.classList.remove('liked');
                element.style.color = '#94a3b8';
            }
            alert(data.message || 'حدث خطأ');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // في حالة الخطأ، نرجع الحالة السابقة
        if (isCurrentlyLiked) {
            element.classList.add('liked');
            element.style.color = '#ef4444';
        } else {
            element.classList.remove('liked');
            element.style.color = '#94a3b8';
        }
        alert('حدث خطأ في الاتصال');
    });
}

// تفعيل زر الإعجاب عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-like').forEach(button => {
        const productId = button.dataset.productId;
        if (productId) {
            // تعيين الحالة الأولية
            if (button.classList.contains('liked')) {
                button.style.color = '#ef4444';
            } else {
                button.style.color = '#94a3b8';
            }
            
            button.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                toggleLike(productId, this);
            };
        }
    });
});

// تفعيل زر الإعجاب عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-like').forEach(button => {
        const productId = button.dataset.productId;
        if (productId) {
            button.onclick = function(e) {
                e.preventDefault();
                toggleLike(productId, this);
            };
        }
    });
});

    function toggleLike(productId, element) {
    fetch(`/products/${productId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const isLiked = data.is_liked;
            const likesCount = data.likes_count;
            
            // تحديث عدد الإعجابات
            const countSpan = element.querySelector('.likes-count');
            countSpan.textContent = likesCount;
            
            // تحديث حالة الزر
            if (isLiked) {
                element.classList.add('liked');
            } else {
                element.classList.remove('liked');
            }
        }
    })
    .catch(error => console.error('Error:', error));
}

        document.addEventListener('DOMContentLoaded', function() {
            const slider = document.getElementById('brightnessSlider');
            const valueDisplay = document.getElementById('brightnessValue');
            const body = document.body;
            const html = document.documentElement;
            
            const savedBrightness = localStorage.getItem('brightness');
            if (savedBrightness) {
                const value = parseInt(savedBrightness);
                slider.value = value;
                const brightness = 0.5 + (value / 100);
                body.style.setProperty('--brightness', brightness);
                valueDisplay.textContent = value + '%';
            }
            
            slider.addEventListener('input', function() {
                const value = parseInt(this.value);
                const brightness = 0.5 + (value / 100);
                body.style.setProperty('--brightness', brightness);
                valueDisplay.textContent = value + '%';
                localStorage.setItem('brightness', value);
                
                if (value < 30) {
                    html.setAttribute('data-theme', 'dark');
                } else if (value > 60) {
                    html.removeAttribute('data-theme');
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
