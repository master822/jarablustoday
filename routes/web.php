<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MerchantDashboardController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ServiceProviderDashboardController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ExportController;

// ============================================
// الصفحة الرئيسية
// ============================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ============================================
// المصادقة
// ============================================
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// نسيان كلمة المرور وإعادة تعيينها
// ============================================
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));
    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
    
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
            $user->save();
        }
    );
    
    if ($status === Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('status', 'تم إعادة تعيين كلمة المرور بنجاح!');
    }
    
    return back()->withErrors(['email' => 'الرابط غير صالح أو منتهي الصلاحية']);
})->middleware('guest')->name('password.update');

// ============================================
// الملف الشخصي (لجميع المستخدمين)
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ProfileController::class, 'showChangePassword'])->name('change-password');
});

// ============================================
// المنتجات (العامة)
// ============================================
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/category/{categorySlug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::post('/products/{id}/like', [ProductController::class, 'toggleLike'])->name('products.like');

// المنتجات المستعملة
Route::get('/used-products', [ProductController::class, 'usedProducts'])->name('used-products');

// ============================================
// التجار
// ============================================
Route::get('/merchants', [MerchantController::class, 'index'])->name('merchants.index');
Route::get('/merchants/{id}', [MerchantController::class, 'show'])->name('merchants.show');
Route::get('/merchants/category/{category}', [MerchantController::class, 'byCategory'])->name('merchants.byCategory');

// ============================================
// التخفيضات
// ============================================
Route::get('/discounts', [DiscountController::class, 'discounts'])->name('discounts');
Route::get('/discounts/{id}', [DiscountController::class, 'show'])->name('discounts.show');

// ============================================
// فرص العمل
// ============================================
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

// ============================================
// الخدمات
// ============================================
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{id}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/services/type/{type}', [ServiceController::class, 'byType'])->name('services.byType');

// ============================================
// البحث
// ============================================
Route::get('/search/products', [SearchController::class, 'searchProducts'])->name('search.products');
Route::get('/search/merchants', [SearchController::class, 'searchMerchants'])->name('search.merchants');
Route::get('/search/discounts', [SearchController::class, 'searchDiscounts'])->name('search.discounts');
Route::get('/search/used-products', [SearchController::class, 'searchUsedProducts'])->name('search.used-products');
Route::get('/search/services', [SearchController::class, 'searchServices'])->name('search.services');

// ============================================
// الرسائل والمحادثات (تحتاج مصادقة)
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/messages/contact/{productId}', [MessageController::class, 'contactMerchantForm'])->name('messages.contact.form');
    Route::post('/messages/contact/{productId}', [MessageController::class, 'contactMerchant'])->name('messages.contact.send');
    Route::get('/messages/contact-provider/{userId}', [MessageController::class, 'contactServiceProviderForm'])->name('messages.contact.provider');
    Route::post('/messages/contact-provider/{userId}', [MessageController::class, 'contactServiceProvider'])->name('messages.contact.provider.send');
    Route::get('/messages/contact-job/{jobId}', [MessageController::class, 'contactJobForm'])->name('messages.contact.job');
    Route::post('/messages/contact-job/{jobId}', [MessageController::class, 'contactJob'])->name('messages.contact.job.send');
    Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::get('/messages/conversation/{userId}', [MessageController::class, 'showConversation'])->name('messages.conversation');
    Route::post('/messages/conversation/{userId}/send', [MessageController::class, 'sendMessageInConversation'])->name('messages.send-conversation');
    Route::post('/messages/conversation/{userId}/clear', [MessageController::class, 'clearConversation'])->name('messages.clear-conversation');
    Route::post('/messages/{id}/mark-as-read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');
    Route::delete('/messages/{id}', [MessageController::class, 'deleteMessage'])->name('messages.delete');
});

// ============================================
// الإشعارات (تحتاج مصادقة)
// ============================================
Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::delete('/{id}', [NotificationController::class, 'delete'])->name('delete');
    Route::delete('/delete-all', [NotificationController::class, 'deleteAll'])->name('delete-all');
});

// ============================================
// الاشتراكات (تحتاج مصادقة)
// ============================================
Route::middleware(['auth'])->prefix('subscription')->name('subscription.')->group(function () {
    Route::get('/plans', [SubscriptionController::class, 'plans'])->name('plans');
    Route::get('/checkout/{plan}', [SubscriptionController::class, 'checkout'])->name('checkout');
    Route::post('/process/{plan}', [SubscriptionController::class, 'processPayment'])->name('process');
    Route::get('/check-status', [SubscriptionController::class, 'checkSubscription'])->name('check');
});

// ============================================
// الاشتراكات - مسارات التاجر
// ============================================
Route::middleware(['auth'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('/subscription/plans', [SubscriptionController::class, 'plans'])->name('subscription.plans');
    Route::get('/subscription/history', [SubscriptionController::class, 'history'])->name('subscription.history');
    Route::post('/subscribe/{plan}', [SubscriptionController::class, 'subscribe'])->name('subscribe');
    Route::get('/payment/{plan}', function ($plan) {
        $plans = [
            'medium' => ['name' => 'الباقة المتوسطة', 'price' => 10, 'product_limit' => 80],
            'gold' => ['name' => 'الباقة الذهبية', 'price' => 20, 'product_limit' => 200],
        ];
        
        if (!isset($plans[$plan])) {
            return redirect()->route('merchant.subscription.plans')->with('error', 'الباقة غير موجودة');
        }
        
        $planData = $plans[$plan];
        return view('merchant.payment', compact('planData', 'plan'));
    })->name('payment');
});

// ============================================
// تصدير البيانات (تحتاج مصادقة)
// ============================================
Route::middleware(['auth'])->prefix('export')->name('export.')->group(function () {
    Route::get('/products', [ExportController::class, 'exportProducts'])->name('products');
    Route::get('/services', [ExportController::class, 'exportServices'])->name('services');
    Route::get('/users', [ExportController::class, 'exportUsers'])->name('users');
    Route::get('/discounts', [ExportController::class, 'exportDiscounts'])->name('discounts');
});

// ============================================
// لوحة تحكم المستخدم العادي
// ============================================
Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [UserDashboardController::class, 'myProducts'])->name('products');
    Route::get('/products/create', [UserDashboardController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [UserDashboardController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [UserDashboardController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [UserDashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [UserDashboardController::class, 'deleteProduct'])->name('products.delete');
    Route::get('/messages', [UserDashboardController::class, 'messages'])->name('messages');
    Route::post('/messages/{id}/read', [UserDashboardController::class, 'markMessageRead'])->name('messages.read');
    Route::get('/profile', [UserDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [UserDashboardController::class, 'changePassword'])->name('change-password');
});

// ============================================
// لوحة تحكم التاجر
// ============================================
Route::middleware(['auth'])->prefix('merchant')->name('merchant.')->group(function () {
    Route::get('/dashboard', [MerchantDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/products', [MerchantDashboardController::class, 'myProducts'])->name('products');
    Route::get('/products/create', [MerchantDashboardController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [MerchantDashboardController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{id}/edit', [MerchantDashboardController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{id}', [MerchantDashboardController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{id}', [MerchantDashboardController::class, 'deleteProduct'])->name('products.delete');
    Route::get('/discounts', [MerchantDashboardController::class, 'discounts'])->name('discounts');
    Route::get('/discounts/create', [MerchantDashboardController::class, 'createDiscount'])->name('discounts.create');
    Route::post('/discounts', [MerchantDashboardController::class, 'storeDiscount'])->name('discounts.store');
    Route::get('/discounts/{id}/edit', [MerchantDashboardController::class, 'editDiscount'])->name('discounts.edit');
    Route::put('/discounts/{id}', [MerchantDashboardController::class, 'updateDiscount'])->name('discounts.update');
    Route::delete('/discounts/{id}', [MerchantDashboardController::class, 'deleteDiscount'])->name('discounts.delete');
    Route::get('/jobs', [MerchantDashboardController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/create', [MerchantDashboardController::class, 'createJob'])->name('jobs.create');
    Route::post('/jobs', [MerchantDashboardController::class, 'storeJob'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [MerchantDashboardController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{id}', [MerchantDashboardController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{id}', [MerchantDashboardController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/messages', [MerchantDashboardController::class, 'messages'])->name('messages');
    Route::post('/messages/{id}/read', [MerchantDashboardController::class, 'markMessageRead'])->name('messages.read');
    Route::get('/profile', [MerchantDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [MerchantDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [MerchantDashboardController::class, 'changePassword'])->name('change-password');
});

// ============================================
// لوحة تحكم مقدم الخدمات
// ============================================
Route::middleware(['auth'])->prefix('service-provider')->name('service-provider.')->group(function () {
    Route::get('/dashboard', [ServiceProviderDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/services', [ServiceProviderDashboardController::class, 'services'])->name('services');
    Route::get('/services/create', [ServiceProviderDashboardController::class, 'createServiceForm'])->name('services.create');
    Route::post('/services', [ServiceProviderDashboardController::class, 'createService'])->name('services.store');
    Route::get('/services/{id}/edit', [ServiceProviderDashboardController::class, 'editService'])->name('services.edit');
    Route::put('/services/{id}', [ServiceProviderDashboardController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{id}', [ServiceProviderDashboardController::class, 'deleteService'])->name('services.delete');
    Route::get('/jobs', [ServiceProviderDashboardController::class, 'jobs'])->name('jobs');
    Route::get('/jobs/create', [ServiceProviderDashboardController::class, 'createJobForm'])->name('jobs.create');
    Route::post('/jobs', [ServiceProviderDashboardController::class, 'createJob'])->name('jobs.store');
    Route::get('/jobs/{id}/edit', [ServiceProviderDashboardController::class, 'editJob'])->name('jobs.edit');
    Route::put('/jobs/{id}', [ServiceProviderDashboardController::class, 'updateJob'])->name('jobs.update');
    Route::delete('/jobs/{id}', [ServiceProviderDashboardController::class, 'deleteJob'])->name('jobs.delete');
    Route::get('/messages', [ServiceProviderDashboardController::class, 'messages'])->name('messages');
    Route::post('/messages/{id}/read', [ServiceProviderDashboardController::class, 'markMessageRead'])->name('messages.read');
    Route::get('/profile', [ServiceProviderDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [ServiceProviderDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [ServiceProviderDashboardController::class, 'changePassword'])->name('change-password');
});

// ============================================
// لوحة تحكم المسؤول (Admin)
// ============================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}', [AdminController::class, 'showUser'])->name('user.show');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('user.edit');
    Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('user.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('user.delete');
    Route::get('/subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions');
    Route::get('/subscriptions/{id}', [AdminController::class, 'showSubscription'])->name('subscription.show');
    Route::get('/subscriptions/{id}/edit', [AdminController::class, 'editSubscription'])->name('subscription.edit');
    Route::put('/subscriptions/{id}', [AdminController::class, 'updateSubscription'])->name('subscription.update');
    Route::post('/subscriptions/{id}/cancel', [AdminController::class, 'cancelSubscription'])->name('subscription.cancel');
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments');
    Route::get('/payments/{id}', [AdminController::class, 'showPayment'])->name('payment.show');
    Route::post('/payments/{id}/approve', [AdminController::class, 'approvePayment'])->name('payment.approve');
    Route::post('/payments/{id}/reject', [AdminController::class, 'rejectPayment'])->name('payment.reject');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('product.delete');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
});

// ============================================
// صفحات ثابتة إضافية
// ============================================
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

Route::get('/make-admin', function() {
    try {
        $user = new App\Models\User();
        $user->name = 'Master Admin';
        $user->email = 'masteradmin@rizk.com';
        $user->password = bcrypt('master927ADMIN');
        $user->user_type = 'admin';
        $user->is_active = true;
        $user->save();
        
        return '✅ تم إنشاء حساب Admin بنجاح!<br><br>📧 <strong>masteradmin@rizk.com</strong><br>🔑 <strong>master927ADMIN</strong><br><br><a href="/login" style="display: inline-block; padding: 10px 20px; background: #b8860b; color: #fff; text-decoration: none; border-radius: 8px;">تسجيل الدخول</a>';
    } catch (\Exception $e) {
        return '❌ خطأ: ' . $e->getMessage();
    }
});

// ============================================
// إعادة تعيين كلمة المرور
// ============================================
Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Illuminate\Http\Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
    
    $status = Illuminate\Support\Facades\Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Illuminate\Support\Facades\Hash::make($password)
            ])->setRememberToken(Illuminate\Support\Str::random(60));
            $user->save();
        }
    );
    
    if ($status === Illuminate\Support\Facades\Password::PASSWORD_RESET) {
        return redirect()->route('login')->with('status', 'تم إعادة تعيين كلمة المرور بنجاح!');
    }
    
    return back()->withErrors(['email' => 'الرابط غير صالح أو منتهي الصلاحية']);
})->middleware('guest')->name('password.update');
