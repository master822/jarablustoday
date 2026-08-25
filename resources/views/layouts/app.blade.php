<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'جرابلس اليوم')</title>
    
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
        

/* ============================================================
   STABLE NAVBAR
   ============================================================ */


/* JURABLUS TODAY SITE NAME */
.site-name-jurablus {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    direction: rtl;
    font-size: 1.4rem;
    font-weight: 800;
    line-height: 1;
    white-space: nowrap;
    letter-spacing: -0.5px;
}

.site-name-jurablus-word {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 7px 11px;
    border-radius: 10px;

    /* Gold site color */
    background: linear-gradient(
        135deg,
        #d4af37,
        #f1d477
    );

    /* Dark text for strong contrast */
    color: #1a1a2e !important;

    -webkit-text-fill-color: #1a1a2e !important;

    box-shadow:
        0 3px 10px rgba(212, 175, 55, 0.25);
}

.site-name-today-word {
    display: inline-block;

    /* Different color from جرابلس */
    background: linear-gradient(
        135deg,
        var(--primary-color),
        var(--primary-light)
    );

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;

    color: var(--primary-color);
}

/* Dark mode */
[data-theme="dark"] .site-name-jurablus-word {
    background: linear-gradient(
        135deg,
        #d4af37,
        #f5d978
    );

    color: #111827 !important;
    -webkit-text-fill-color: #111827 !important;

    box-shadow:
        0 3px 12px rgba(212, 175, 55, 0.35);
}

[data-theme="dark"] .site-name-today-word {
    background: linear-gradient(
        135deg,
        #818cf8,
        #c4b5fd
    );

    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

@media (max-width: 768px) {
    .site-name-jurablus {
        font-size: 1.15rem;
        gap: 5px;
    }

    .site-name-jurablus-word {
        padding: 6px 9px;
        border-radius: 8px;
    }
}

.navbar-rizk {
    position: fixed !important;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 1030;
    min-height: 64px;
    background: var(--bg-navbar) !important;
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
}

.navbar-rizk .container {
    display: flex;
    align-items: center;
    min-height: 64px;
}

.navbar-rizk .navbar-collapse {
    align-items: center;
}

.navbar-rizk .navbar-toggler {
    padding: 6px 9px;
    border-radius: 10px;
}

.navbar-rizk .navbar-toggler:focus {
    box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.25);
}


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
    text-align: center;
}

.section-title-rizk::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 250px;
    height: 4px;
    background: linear-gradient(
        90deg,
        var(--primary-color),
        var(--secondary-color)
    );
    border-radius: 999px;
}
        
        .gold-text { color: var(--primary-color); }
        
        
/* ============================================================
   RIZK THEME TOGGLE - NORMAL BUTTON
   ============================================================ */

.theme-toggle {
    width: 48px;
    height: 48px;
    padding: 0;
    border: 1px solid rgba(212, 175, 55, 0.25);
    border-radius: 12px;
    background: var(--bg-card);
    color: var(--text-primary);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: var(--shadow-sm);
    transition: background-color .25s ease,
                color .25s ease,
                border-color .25s ease,
                transform .2s ease,
                box-shadow .25s ease;
}

.theme-toggle:hover {
    transform: translateY(-1px);
    border-color: var(--primary-color);
    box-shadow: var(--shadow-md);
}

.theme-toggle:active {
    transform: translateY(0);
}

.theme-toggle i {
    font-size: 1.05rem;
    transition: transform .25s ease;
}

.theme-toggle:hover i {
    transform: rotate(15deg);
}

[data-theme="dark"] .theme-toggle {
    background: #1e293b;
    color: #f0d060;
    border-color: rgba(240, 208, 96, 0.25);
}

@media (max-width: 768px) {
    .theme-toggle {
        width: 42px;
        height: 42px;
        border-radius: 10px;
    }
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
    .navbar-rizk .brand-icon { width: 36px; height: 36px; font-size: 1rem; }.product-card .product-title { font-size: 0.9rem; }
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
    .footer-rizk { padding: 30px 0 15px; }/* تحسين عرض المنتجات */
    .product-grid .col-lg-3 { flex: 0 0 50%; max-width: 50%; }
    .product-card .product-description { font-size: 0.75rem; }
    .pagination-simple .page-btn { padding: 8px 16px; min-width: 80px; font-size: 0.8rem; }
}

@media (max-width: 576px) {
    body { padding-top: 56px; font-size: 12px; }
    .container { padding-left: 10px; padding-right: 10px; }/* تحسين عرض المنتجات في الشاشات الصغيرة */
    .product-grid .col-6 { flex: 0 0 50%; max-width: 50%; }
    .product-card .product-title { font-size: 0.8rem; }
    .product-card .product-price { font-size: 0.9rem; }
    .product-card .product-meta { font-size: 0.6rem; }
    .product-actions .btn-sm { font-size: 0.65rem; padding: 4px 6px; }
    
    .pagination-simple .page-btn { padding: 6px 12px; min-width: 60px; font-size: 0.7rem; gap: 4px; }
    .pagination-simple .page-info { font-size: 0.7rem; }
}
    
/* ===== FIX NAVBAR ITEM POSITION ===== */
.navbar-rizk .navbar-collapse {
    flex-grow: 1;
}

.navbar-rizk .navbar-nav {
    align-items: center;
}

.navbar-rizk .navbar-nav.me-auto {
    margin-right: 0 !important;
    margin-left: auto !important;
    gap: 2px;
}

.navbar-rizk .navbar-nav.ms-auto {
    margin-right: auto !important;
    margin-left: 0 !important;
    flex-shrink: 0;
}

.navbar-rizk .nav-item {
    flex-shrink: 0;
}

.navbar-rizk .nav-link {
    white-space: nowrap;
}

@media (max-width: 1199.98px) {
    .navbar-rizk .nav-link {
        padding: 7px 9px;
        font-size: 0.82rem;
    }
}

@media (max-width: 991.98px) {
    .navbar-rizk .navbar-collapse {
        padding: 12px 0;
    }

    .navbar-rizk .navbar-nav.me-auto {
        margin: 0 !important;
        align-items: stretch;
    }

    .navbar-rizk .navbar-nav.ms-auto {
        margin: 10px 0 0 !important;
        align-items: center;
    }

    .navbar-rizk .nav-link {
        padding: 9px 12px;
    }
}

    
/* ===== COMPACT RIZK NAVBAR ===== */

.navbar-rizk {
    padding: 7px 0 !important;
}

.navbar-rizk .container {
    min-height: 58px;
}

.navbar-rizk .navbar-brand {
    font-size: 1.35rem;
    gap: 8px;
}

.navbar-rizk .brand-icon {
    width: 38px;
    height: 38px;
    font-size: 1rem;
}

.navbar-rizk .nav-link {
    padding: 6px 10px;
    font-size: 0.88rem;
}

.navbar-rizk .navbar-nav.me-auto {
    gap: 0;
}

.navbar-rizk .dropdown-menu {
    min-width: 210px;
    margin-top: 6px;
}

.navbar-rizk .dropdown-item {
    padding: 9px 12px;
    font-size: 0.88rem;
}

@media (max-width: 1199.98px) {
    .navbar-rizk .nav-link {
        padding: 6px 7px;
        font-size: 0.8rem;
    }
}

@media (max-width: 991.98px) {
    .navbar-rizk {
        padding: 5px 0 !important;
    }

    .navbar-rizk .container {
        min-height: 52px;
    }

    .navbar-rizk .navbar-nav.me-auto {
        gap: 2px;
    }

    .navbar-rizk .nav-link {
        padding: 8px 12px;
        font-size: 0.85rem;
    }
}

    
/* ============================================================
   FINAL NAVBAR LAYOUT
   ============================================================ */

.navbar-rizk {
    padding: 6px 0 !important;
}

.navbar-rizk .container {
    min-height: 58px;
    display: flex;
    align-items: center;
}

.navbar-rizk .navbar-collapse {
    align-items: center;
}

.navbar-rizk .navbar-nav.me-auto {
    margin-right: 0 !important;
    margin-left: auto !important;
    align-items: center;
    gap: 0;
}

.navbar-rizk .navbar-nav.ms-auto {
    margin-right: auto !important;
    margin-left: 0 !important;
    align-items: center;
}

.navbar-rizk .nav-item {
    flex-shrink: 0;
}

.navbar-rizk .nav-link {
    padding: 6px 9px;
    font-size: 0.86rem;
    white-space: nowrap;
}

.navbar-rizk .dropdown-menu {
    min-width: 210px;
    margin-top: 6px;
}

.navbar-rizk .dropdown-item {
    padding: 9px 12px;
    font-size: 0.86rem;
    white-space: nowrap;
}

@media (max-width: 1199px) {
    .navbar-rizk .nav-link {
        padding: 5px 6px;
        font-size: 0.78rem;
    }
}

@media (max-width: 991px) {
    .navbar-rizk .navbar-collapse {
        padding: 10px 0;
    }

    .navbar-rizk .navbar-nav.me-auto,
    .navbar-rizk .navbar-nav.ms-auto {
        margin: 0 !important;
        align-items: stretch;
    }

    .navbar-rizk .nav-link {
        padding: 8px 12px;
        font-size: 0.85rem;
    }
}



/* =========================================================
   AUTH PAGES - LOGIN / REGISTER / PASSWORD
   ========================================================= */


/* FORCE DARK MODE AUTH TEXT VISIBILITY */
[data-theme="dark"] .auth-page h1,
[data-theme="dark"] .auth-page h2,
[data-theme="dark"] .auth-page h3,
[data-theme="dark"] .auth-page h4,
[data-theme="dark"] .auth-page h5,
[data-theme="dark"] .auth-page h6,
[data-theme="dark"] .auth-page label,
[data-theme="dark"] .auth-page .form-label,
[data-theme="dark"] .auth-page p,
[data-theme="dark"] .auth-page span:not(.badge),
[data-theme="dark"] .auth-page .form-check-label {
    color: #f8fafc !important;
}

[data-theme="dark"] .auth-page input,
[data-theme="dark"] .auth-page textarea,
[data-theme="dark"] .auth-page select,
[data-theme="dark"] .auth-page .form-control,
[data-theme="dark"] .auth-page .form-select {
    color: #f8fafc !important;
    background-color: #1e293b !important;
    border-color: #475569 !important;
}

[data-theme="dark"] .auth-page input:focus,
[data-theme="dark"] .auth-page textarea:focus,
[data-theme="dark"] .auth-page select:focus,
[data-theme="dark"] .auth-page .form-control:focus,
[data-theme="dark"] .auth-page .form-select:focus {
    color: #ffffff !important;
    background-color: #1e293b !important;
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.20) !important;
}

[data-theme="dark"] .auth-page input::placeholder,
[data-theme="dark"] .auth-page textarea::placeholder {
    color: #94a3b8 !important;
    opacity: 1 !important;
}

[data-theme="dark"] .auth-page .text-muted {
    color: #cbd5e1 !important;
}

[data-theme="dark"] .auth-page a {
    color: #60a5fa !important;
}

[data-theme="dark"] .auth-page a:hover {
    color: #93c5fd !important;
}

.auth-page {
    min-height: calc(100vh - 80px);
    padding: 40px 15px 60px;
    display: flex;
    align-items: flex-start;
    justify-content: center;
}

.auth-page .container,
.auth-page .row {
    width: 100%;
}

.auth-page .card,
.auth-page .auth-card {
    background: var(--bg-card) !important;
    color: var(--text-primary) !important;
    border-color: rgba(212, 175, 55, 0.20) !important;
}

.auth-page h1,
.auth-page h2,
.auth-page h3,
.auth-page h4,
.auth-page h5,
.auth-page h6,
.auth-page label,
.auth-page p,
.auth-page span {
    color: var(--text-primary);
}

.auth-page .text-muted {
    color: var(--text-secondary) !important;
}

.auth-page input,
.auth-page textarea,
.auth-page select,
.auth-page .form-control,
.auth-page .form-select {
    background-color: var(--bg-card) !important;
    color: var(--text-primary) !important;
    border: 1px solid rgba(148, 163, 184, 0.35) !important;
}

.auth-page input::placeholder,
.auth-page textarea::placeholder {
    color: var(--text-muted) !important;
    opacity: 1;
}

.auth-page input:focus,
.auth-page textarea:focus,
.auth-page select:focus,
.auth-page .form-control:focus,
.auth-page .form-select:focus {
    background-color: var(--bg-card) !important;
    color: var(--text-primary) !important;
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.15) !important;
}

.auth-page .form-check-label {
    color: var(--text-secondary) !important;
}

.auth-page a {
    color: var(--primary-color) !important;
}

.auth-page a:hover {
    color: var(--primary-light) !important;
}

/* Dark mode */
[data-theme="dark"] .auth-page input,
[data-theme="dark"] .auth-page textarea,
[data-theme="dark"] .auth-page select,
[data-theme="dark"] .auth-page .form-control,
[data-theme="dark"] .auth-page .form-select {
    background-color: #1e293b !important;
    color: #f1f5f9 !important;
    border-color: #475569 !important;
}

[data-theme="dark"] .auth-page input::placeholder,
[data-theme="dark"] .auth-page textarea::placeholder {
    color: #94a3b8 !important;
}

[data-theme="dark"] .auth-page .card,
[data-theme="dark"] .auth-page .auth-card {
    background-color: #1e293b !important;
    color: #f1f5f9 !important;
}

/* Never allow auth content to hide behind fixed navbar */
@media (min-width: 769px) {
    .auth-page {
        padding-top: 35px;
    }
}

@media (max-width: 768px) {
    .auth-page {
        min-height: calc(100vh - 64px);
        padding: 25px 12px 40px;
    }
}

@media (max-width: 576px) {
    .auth-page {
        min-height: calc(100vh - 56px);
        padding: 20px 10px 35px;
    }
}



/* Auth pages must not inherit global brightness filter */
body.auth-layout {
    filter: none !important;
}



/* =========================================================
   FINAL AUTH PAGE FIX
   ========================================================= */

.auth-page {
    position: relative;
    z-index: 1;
    width: 100%;
    max-width: 100%;
    min-height: calc(100vh - 80px);
    margin: 0 auto;
    padding: 35px 15px 60px !important;
    color: var(--text-primary) !important;
}

.auth-page > .row {
    margin-left: auto;
    margin-right: auto;
}

.auth-page .modern-card,
.auth-page .card-rizk,
.auth-page .card {
    background-color: var(--bg-card) !important;
    color: var(--text-primary) !important;
    border-color: rgba(212, 175, 55, 0.20) !important;
}

.auth-page h1,
.auth-page h2,
.auth-page h3,
.auth-page h4,
.auth-page h5,
.auth-page h6,
.auth-page p,
.auth-page label,
.auth-page strong,
.auth-page span {
    color: var(--text-primary);
}

.auth-page .text-muted,
.auth-page small {
    color: var(--text-secondary) !important;
}

/* Inputs - Light + Dark */
.auth-page input:not([type="checkbox"]):not([type="radio"]),
.auth-page textarea,
.auth-page select,
.auth-page .form-control,
.auth-page .form-select {
    background-color: var(--bg-card) !important;
    color: var(--text-primary) !important;
    border: 1px solid rgba(148, 163, 184, 0.40) !important;
    opacity: 1 !important;
}

.auth-page input:not([type="checkbox"]):not([type="radio"])::placeholder,
.auth-page textarea::placeholder {
    color: var(--text-muted) !important;
    opacity: 1 !important;
}

.auth-page input:focus,
.auth-page textarea:focus,
.auth-page select:focus,
.auth-page .form-control:focus,
.auth-page .form-select:focus {
    background-color: var(--bg-card) !important;
    color: var(--text-primary) !important;
    border-color: var(--primary-color) !important;
    box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.15) !important;
}

/* Bootstrap autofill */
.auth-page input:-webkit-autofill,
.auth-page input:-webkit-autofill:hover,
.auth-page input:-webkit-autofill:focus,
.auth-page textarea:-webkit-autofill,
.auth-page select:-webkit-autofill {
    -webkit-text-fill-color: var(--text-primary) !important;
    box-shadow: 0 0 0 1000px var(--bg-card) inset !important;
    transition: background-color 9999s ease-in-out 0s;
}

/* Checkboxes */
.auth-page .form-check-input {
    background-color: var(--bg-card) !important;
    border-color: var(--text-muted) !important;
}

.auth-page .form-check-input:checked {
    background-color: var(--primary-color) !important;
    border-color: var(--primary-color) !important;
}

.auth-page .form-check-label {
    color: var(--text-secondary) !important;
}

/* Links */
.auth-page a:not(.btn) {
    color: var(--primary-color) !important;
}

.auth-page a:not(.btn):hover {
    color: var(--primary-light) !important;
}

/* Alerts */
.auth-page .alert {
    color: var(--text-primary) !important;
}

.auth-page .alert-danger {
    color: #fca5a5 !important;
}

.auth-page .alert-success {
    color: #86efac !important;
}

/* =========================================================
   DARK MODE
   ========================================================= */

[data-theme="dark"] .auth-page {
    color: #f1f5f9 !important;
}

[data-theme="dark"] .auth-page .modern-card,
[data-theme="dark"] .auth-page .card-rizk,
[data-theme="dark"] .auth-page .card {
    background: #1e293b !important;
    color: #f1f5f9 !important;
}

[data-theme="dark"] .auth-page h1,
[data-theme="dark"] .auth-page h2,
[data-theme="dark"] .auth-page h3,
[data-theme="dark"] .auth-page h4,
[data-theme="dark"] .auth-page h5,
[data-theme="dark"] .auth-page h6,
[data-theme="dark"] .auth-page p,
[data-theme="dark"] .auth-page label,
[data-theme="dark"] .auth-page strong,
[data-theme="dark"] .auth-page span {
    color: #f1f5f9;
}

[data-theme="dark"] .auth-page .text-muted,
[data-theme="dark"] .auth-page small {
    color: #cbd5e1 !important;
}

[data-theme="dark"] .auth-page input:not([type="checkbox"]):not([type="radio"]),
[data-theme="dark"] .auth-page textarea,
[data-theme="dark"] .auth-page select,
[data-theme="dark"] .auth-page .form-control,
[data-theme="dark"] .auth-page .form-select {
    background: #0f172a !important;
    color: #f8fafc !important;
    border-color: #475569 !important;
}

[data-theme="dark"] .auth-page input:not([type="checkbox"]):not([type="radio"])::placeholder,
[data-theme="dark"] .auth-page textarea::placeholder {
    color: #94a3b8 !important;
}

[data-theme="dark"] .auth-page input:focus,
[data-theme="dark"] .auth-page textarea:focus,
[data-theme="dark"] .auth-page select:focus,
[data-theme="dark"] .auth-page .form-control:focus,
[data-theme="dark"] .auth-page .form-select:focus {
    background: #0f172a !important;
    color: #f8fafc !important;
    border-color: #f0d060 !important;
}

/* Prevent fixed navbar from covering auth content */
@media (min-width: 769px) {
    .auth-page {
        padding-top: 35px !important;
    }
}

@media (max-width: 768px) {
    .auth-page {
        min-height: calc(100vh - 64px);
        padding: 25px 12px 45px !important;
    }
}

@media (max-width: 576px) {
    .auth-page {
        min-height: calc(100vh - 56px);
        padding: 20px 10px 35px !important;
    }
}


/* ============================================================
   RESPONSIVE NOTIFICATIONS / MESSAGES DROPDOWNS
   ============================================================ */

/*
 * Desktop
 *
 * لا نستخدم position: fixed هنا.
 * Bootstrap يضع القائمة بالنسبة إلى عنصر الـdropdown
 * وبالتالي تبقى مرتبطة بالأيقونة نفسها.
 */
.navbar-rizk .rizk-fixed-dropdown {
    position: absolute !important;

    z-index: 2000 !important;

    width: 350px !important;
    min-width: 350px !important;
    max-width: min(350px, calc(100vw - 24px)) !important;

    max-height: calc(100vh - 90px) !important;

    margin-top: 6px !important;

    overflow-x: hidden !important;
    overflow-y: auto !important;

    box-sizing: border-box !important;
}

/*
 * الإشعارات والرسائل:
 * dropdown-menu-end يجعل الحافة اليمنى للقائمة
 * مرتبطة بعنصر الـdropdown نفسه.
 */
.navbar-rizk .rizk-notifications-dropdown,
.navbar-rizk .rizk-messages-dropdown {
    inset-inline-end: 0 !important;
    inset-inline-start: auto !important;

    top: 100% !important;
    bottom: auto !important;
}

/* محتوى الإشعارات لا يسمح للنص بتوسيع القائمة */
.navbar-rizk .rizk-notifications-dropdown .dropdown-item {
    width: 100%;
    max-width: 100%;

    white-space: normal !important;

    overflow-wrap: anywhere;
    word-break: break-word;

    box-sizing: border-box;
}

.navbar-rizk .rizk-notifications-dropdown .dropdown-item > div {
    min-width: 0;
    max-width: 100%;
}

.navbar-rizk .rizk-notifications-dropdown strong,
.navbar-rizk .rizk-notifications-dropdown p,
.navbar-rizk .rizk-notifications-dropdown small {
    overflow-wrap: anywhere;
    word-break: break-word;
}

/* ============================================================
   TABLETS
   ============================================================ */

@media (max-width: 991.98px) {

    .navbar-rizk .rizk-fixed-dropdown {
        width: min(340px, calc(100vw - 20px)) !important;
        min-width: 0 !important;

        max-width: calc(100vw - 20px) !important;

        max-height: calc(100vh - 80px) !important;
    }
}

/* ============================================================
   PHONES
   ============================================================ */

@media (max-width: 576px) {

    .navbar-rizk .rizk-fixed-dropdown {
        /*
         * على الهاتف نريد القائمة مرتبطة بالـnavbar
         * ولكن لا تتجاوز حدود الشاشة.
         */
        position: fixed !important;

        top: 58px !important;

        width: calc(100vw - 16px) !important;
        min-width: 0 !important;
        max-width: calc(100vw - 16px) !important;

        margin: 0 !important;

        max-height: calc(100vh - 70px) !important;

        border-radius: 12px !important;

        overflow-y: auto !important;
    }

    /*
     * RTL:
     * القائمة تتمركز داخل الشاشة على الهاتف.
     */
    .navbar-rizk .rizk-notifications-dropdown,
    .navbar-rizk .rizk-messages-dropdown {
        left: 8px !important;
        right: 8px !important;

        width: auto !important;
        max-width: none !important;
    }
}

/* ============================================================
   VERY SMALL PHONES
   ============================================================ */

@media (max-width: 360px) {

    .navbar-rizk .rizk-fixed-dropdown {
        left: 6px !important;
        right: 6px !important;

        width: auto !important;

        max-height: calc(100vh - 66px) !important;

        font-size: 0.9rem;
    }

    .navbar-rizk .rizk-notifications-dropdown .dropdown-item {
        padding: 9px 10px !important;
    }
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
<body class="{{ request()->routeIs('login', 'register', 'password.*') ? 'auth-layout' : '' }}">
    <!-- النافبار -->
    <nav class="navbar navbar-expand-lg navbar-rizk fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
    @if(session('site_logo'))
        <img src="{{ asset('storage/' . session('site_logo')) }}" 
             alt="جرابلس اليوم" 
             style="height: 45px; width: auto; max-width: 150px; object-fit: contain;">
    @else
        <!-- <div class="brand-icon"><i class="fas fa-gem"></i></div> -->
        <div>
            <span class="site-name-jurablus">
    <span class="site-name-jurablus-word">جرابلس</span>
    <span class="site-name-today-word">اليوم</span>
</span>
           <!-- <span style="font-size: 0.65rem; font-weight: 400; color: var(--text-muted); display: block; margin-top: -4px;">رزق</span> -->
        </div>
    @endif
</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto align-items-lg-center">


                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/products') }}">المنتجات</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/discounts') }}">التخفيضات</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/used-products') }}">المستعمل</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/services') }}">خدمات</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/jobs') }}">فرص العمل</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/news') }}">آخر الأخبار</a>
                    </li>

                    <!-- عقارات -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           id="propertiesDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            عقارات
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end"
                            aria-labelledby="propertiesDropdown">

                            <li>
                                <a class="dropdown-item"
                                   href="{{ url('/properties/sale') }}">
                                    <i class="fas fa-house me-2"></i>
                                    عقارات للبيع
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item"
                                   href="{{ url('/properties/rent') }}">
                                    <i class="fas fa-key me-2"></i>
                                    عقارات للإيجار
                                </a>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/announcements') }}">الإعلانات</a>
                    </li>

@auth

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle"
       href="#"
       id="createDropdown"
       role="button"
       data-bs-toggle="dropdown"
       aria-expanded="false">
        <i class="fas fa-plus-circle me-1"></i>
        إنشاء
    </a>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="createDropdown">

        <li>
            <a class="dropdown-item" href="{{ route('news.create') }}">
                <i class="fas fa-newspaper me-2"></i>
                إضافة خبر
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="{{ route('announcements.create') }}">
                <i class="fas fa-bullhorn me-2"></i>
                إضافة إعلان
            </a>
        </li>

        <li>
            <a class="dropdown-item" href="{{ route('properties.create') }}">
                <i class="fas fa-house me-2"></i>
                إضافة عقار
            </a>
        </li>

    </ul>
</li>

@endauth

                </ul>
                
                <ul class="navbar-nav ms-auto align-items-center gap-2">

                    <!-- الوضع الليلي / النهاري -->
                    <li class="nav-item">
                        <button
                            type="button"
                            id="themeToggle"
                            class="theme-toggle"
                            aria-label="تبديل الوضع الليلي والنهاري"
                            title="تبديل الوضع الليلي والنهاري">
                            <i id="themeToggleIcon" class="fas fa-moon"></i>
                        </button>
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
                            <ul id="notificationsDropdownMenu"
    class="dropdown-menu dropdown-menu-end rizk-fixed-dropdown rizk-notifications-dropdown"
    style="min-width: 350px; max-height: 400px; overflow-y: auto;">
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
                                               href="{{ $notification->link ?? route('notifications.index') }}"
                                               data-notification-id="{{ $notification->id }}">
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
                            <ul id="messagesDropdownMenu"
    class="dropdown-menu dropdown-menu-end rizk-fixed-dropdown rizk-messages-dropdown">
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
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.posts') }}">
                                            <i class="fas fa-layer-group me-1"></i>
                                            منشوراتي
                                        </a>
                                    </li>
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
             alt="جرابلس اليوم" 
             style="height: 55px; width: auto; max-width: 180px; object-fit: contain; margin-bottom: 10px;">
    @else
        <h5 style="color: #fff;">جرابلس اليوم</h5>
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
                        <!-- <li><a href="{{ url('/merchants') }}">المتاجر</a></li> -->
                        <li><a href="{{ url('/discounts') }}">التخفيضات</a></li>
                        <li><a href="{{ url('/used-products') }}">المستعمل</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6>معلومات الاتصال</h6>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-phone gold-text me-2"></i> 784 128 939 963+</li>
                        <li><i class="fas fa-envelope gold-text me-2"></i> mastersniper823@gmail.com</li>
                        <li><i class="fas fa-map-marker-alt gold-text me-2"></i> سوريا  - حلب</li>
                    </ul>
                </div>
            </div>
            <hr class="my-3" style="border-color: rgba(255,255,255,0.1);">
            <div class="text-center small">&copy; {{ date('Y') }} Jarablus Today - جميع الحقوق محفوظة</div>
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
});
    </script>
    

<script>
(function () {
    'use strict';

    function applyTheme(theme) {
        const html = document.documentElement;
        const icon = document.getElementById('themeToggleIcon');
        const button = document.getElementById('themeToggle');

        if (theme === 'dark') {
            html.setAttribute('data-theme', 'dark');

            if (icon) {
                icon.className = 'fas fa-sun';
            }

            if (button) {
                button.setAttribute('aria-label', 'التبديل إلى الوضع النهاري');
                button.setAttribute('title', 'الوضع النهاري');
            }
        } else {
            html.removeAttribute('data-theme');

            if (icon) {
                icon.className = 'fas fa-moon';
            }

            if (button) {
                button.setAttribute('aria-label', 'التبديل إلى الوضع الليلي');
                button.setAttribute('title', 'الوضع الليلي');
            }
        }
    }

    function initializeTheme() {
        const savedTheme = localStorage.getItem('rizk-theme');

        if (savedTheme === 'dark' || savedTheme === 'light') {
            applyTheme(savedTheme);
        } else {
            applyTheme('light');
        }

        const button = document.getElementById('themeToggle');

        if (button && !button.dataset.themeBound) {
            button.dataset.themeBound = '1';

            button.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();

                const currentTheme =
                    document.documentElement.getAttribute('data-theme');

                const nextTheme =
                    currentTheme === 'dark' ? 'light' : 'dark';

                localStorage.setItem('rizk-theme', nextTheme);
                applyTheme(nextTheme);
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeTheme);
    } else {
        initializeTheme();
    }
})();
</script>

    @stack('scripts')
</body>
</html>
