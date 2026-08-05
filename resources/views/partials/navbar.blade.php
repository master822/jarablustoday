<nav class="navbar navbar-expand-lg navbar-dark" style="background: #1a1a2e;">
    <div class="container">
        <a class="navbar-brand" href="/">
            <span style="color: #d4af37; font-weight: bold;">Rizk</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="/">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link" href="/products">المنتجات</a></li>
                <li class="nav-item"><a class="nav-link" href="/merchants">المتاجر</a></li>
                <li class="nav-item"><a class="nav-link" href="/discounts">التخفيضات</a></li>
                <li class="nav-item"><a class="nav-link" href="/used-products">المستعمل</a></li>
                <li class="nav-item"><a class="nav-link" href="/services">خدمات</a></li>
                <li class="nav-item"><a class="nav-link" href="/jobs">فرص العمل</a></li>
            </ul>

            <ul class="navbar-nav">
                @auth
                    <!-- ===== زر لوحة التحكم (يظهر للجميع) ===== -->
                    <li class="nav-item">
                        <a class="nav-link" href="/service-provider/dashboard" style="color: #d4af37; font-weight: bold; border: 1px solid #d4af37; border-radius: 8px; padding: 5px 15px;">
                            <i class="fas fa-tools"></i> لوحة التحكم
                        </a>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="/service-provider/dashboard"><i class="fas fa-tools" style="color: #d4af37;"></i> لوحة التحكم</a></li>
                            <li><a class="dropdown-item" href="/profile"><i class="fas fa-edit"></i> الملف الشخصي</a></li>
                            <li><a class="dropdown-item" href="/messages/inbox"><i class="fas fa-envelope"></i> الرسائل</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: right;">
                                        <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-sm text-white" href="{{ route('register') }}" style="background: #d4af37; border-radius: 20px; padding: 5px 15px;">إنشاء حساب</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
