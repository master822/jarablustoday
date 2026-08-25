<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\PaymentRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Property;
use App\Models\ContentComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // التحقق من أن المستخدم مسؤول
        $this->middleware(function ($request, $next) {
            if (auth()->user()->user_type !== 'admin') {
                abort(403, 'غير مصرح لك بالدخول إلى هذه الصفحة');
            }
            return $next($request);
        });
    }

// عرض الملف الشخصي للمسؤول
public function profile()
{
    $user = auth()->user();
    return view('admin.profile', compact('user'));
}

// تحديث الملف الشخصي للمسؤول
public function updateProfile(Request $request)
{
    $user = auth()->user();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'site_name' => 'nullable|string|max:255',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }
    
    // تحديث إعدادات الموقع (يمكن تخزينها في جدول settings)
    if ($request->has('site_name')) {
        // تخزين في session أو في جدول settings
        session(['site_name' => $request->site_name]);
    }
    
    if ($request->hasFile('logo')) {
        $path = $request->file('logo')->store('logos', 'public');
        session(['site_logo' => $path]);
    }
    
    $user->save();

    return redirect()->route('admin.profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
}

    // لوحة التحكم الرئيسية
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalMerchants = User::where('user_type', 'merchant')->count();
        $totalProducts = Product::count();
        $totalSubscriptions = Subscription::where('status', 'active')->count();
        $pendingPayments = PaymentRequest::where('status', 'pending')->count();
        
        $recentUsers = User::orderBy('created_at', 'desc')->limit(10)->get();
        $recentSubscriptions = Subscription::with('user')->orderBy('created_at', 'desc')->limit(10)->get();
        
        return view('admin.dashboard', compact(
            'totalUsers', 'totalMerchants', 'totalProducts',
            'totalSubscriptions', 'pendingPayments',
            'recentUsers', 'recentSubscriptions'
        ));
    }

    // عرض جميع المستخدمين
    public function users()
    {
        $users = User::with(['subscriptions' => function($query) {
            $query->where('status', 'active');
        }])->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.users', compact('users'));
    }

    // عرض مستخدم معين
    public function showUser($id)
    {
        $user = User::with(['subscriptions', 'products'])->findOrFail($id);
        return view('admin.user-details', compact('user'));
    }

    // تحرير مستخدم
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user-edit', compact('user'));
    }

    // تحديث مستخدم
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'user_type' => 'required|in:user,merchant,admin',
            'is_active' => 'boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->user_type = $request->user_type;
        $user->is_active = $request->has('is_active');
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('admin.users')->with('success', 'تم تحديث المستخدم بنجاح');
    }

    // حذف مستخدم
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'تم حذف المستخدم بنجاح');
    }

    // عرض جميع الاشتراكات
    public function subscriptions()
    {
        $subscriptions = Subscription::with(['user', 'paymentRequests'])
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(20);
        
        return view('admin.subscriptions', compact('subscriptions'));
    }

    // عرض اشتراك معين
    public function showSubscription($id)
    {
        $subscription = Subscription::with(['user', 'paymentRequests'])->findOrFail($id);
        return view('admin.subscription-details', compact('subscription'));
    }

    // تحرير اشتراك
    public function editSubscription($id)
    {
        $subscription = Subscription::with('user')->findOrFail($id);
        return view('admin.subscription-edit', compact('subscription'));
    }

    // تحديث اشتراك
    public function updateSubscription(Request $request, $id)
    {
        $subscription = Subscription::findOrFail($id);
        
        $request->validate([
            'plan' => 'required|in:medium,gold',
            'product_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,active,expired,cancelled',
        ]);

        $subscription->plan = $request->plan;
        $subscription->product_limit = $request->product_limit;
        $subscription->start_date = $request->start_date;
        $subscription->end_date = $request->end_date;
        $subscription->status = $request->status;
        $subscription->save();

        // تحديث product_limit في جدول المستخدم
        if ($request->status == 'active') {
            $user = User::find($subscription->user_id);
            $user->product_limit = $request->product_limit;
            $user->save();
        }

        return redirect()->route('admin.subscriptions')->with('success', 'تم تحديث الاشتراك بنجاح');
    }

    // إلغاء اشتراك
    public function cancelSubscription($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->status = 'cancelled';
        $subscription->save();
        
        return redirect()->route('admin.subscriptions')->with('success', 'تم إلغاء الاشتراك بنجاح');
    }

    // عرض جميع طلبات الدفع
    public function payments()
    {
        $payments = PaymentRequest::with('user')
                                 ->orderBy('created_at', 'desc')
                                 ->paginate(20);
        
        return view('admin.payments', compact('payments'));
    }

    // عرض تفاصيل طلب دفع
    public function showPayment($id)
    {
        $payment = PaymentRequest::with('user')->findOrFail($id);
        return view('admin.payment-details', compact('payment'));
    }

    // الموافقة على طلب دفع
    public function approvePayment($id)
    {
        $payment = PaymentRequest::findOrFail($id);
        $payment->status = 'approved';
        $payment->save();

        // إنشاء اشتراك للمستخدم
        $plans = [
            'medium' => ['product_limit' => 80],
            'gold' => ['product_limit' => 200],
        ];

        $subscription = Subscription::create([
            'user_id' => $payment->user_id,
            'plan' => $payment->plan,
            'product_limit' => $plans[$payment->plan]['product_limit'],
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'active',
            'activated_at' => now(),
        ]);

        // تحديث product_limit في جدول المستخدم
        $user = User::find($payment->user_id);
        $user->product_limit = $plans[$payment->plan]['product_limit'];
        $user->save();

        // إرسال إشعار للمستخدم
        \App\Models\Notification::create([
            'user_id' => $payment->user_id,
            'sender_id' => auth()->id(),
            'type' => 'subscription',
            'title' => 'تم تفعيل اشتراكك',
            'message' => 'تم تفعيل اشتراكك في الباقة ' . $payment->plan . ' اعتباراً من اليوم ولمدة شهر واحد',
            'link' => route('subscription.plans'),
            'is_read' => false,
        ]);

        return redirect()->route('admin.payments')->with('success', 'تم تفعيل الاشتراك بنجاح');
    }

    // رفض طلب دفع
    public function rejectPayment($id)
    {
        $payment = PaymentRequest::findOrFail($id);
        $payment->status = 'rejected';
        $payment->save();

        return redirect()->route('admin.payments')->with('success', 'تم رفض طلب الدفع');
    }

    // عرض جميع المنتجات
    public function products()
    {
        $products = Product::with(['user', 'category'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);
        
        return view('admin.products', compact('products'));
    }

    // حذف منتج
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'تم حذف المنتج بنجاح');
    }

    // عرض الإحصائيات
    public function statistics()
    {
        $totalUsers = User::count();
        $totalMerchants = User::where('user_type', 'merchant')->count();
        $totalProducts = Product::count();
        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::where('status', 'active')->count();
        $totalPayments = PaymentRequest::sum('amount');
        $pendingPayments = PaymentRequest::where('status', 'pending')->count();
        
        $usersByType = User::select('user_type', \DB::raw('count(*) as total'))
                          ->groupBy('user_type')
                          ->get();
        
        $subscriptionsByPlan = Subscription::select('plan', \DB::raw('count(*) as total'))
                                          ->groupBy('plan')
                                          ->get();
        
        return view('admin.statistics', compact(
            'totalUsers', 'totalMerchants', 'totalProducts',
            'totalSubscriptions', 'activeSubscriptions',
            'totalPayments', 'pendingPayments',
            'usersByType', 'subscriptionsByPlan'
        ));
    }

    public function news()
    {
        $items = News::with(['user', 'approver'])
            ->latest()
            ->paginate(20);

        return view('admin.news', compact('items'));
    }

private function removePendingNotification($title)
{
    Notification::where('type', 'content_pending')
        ->where('message', 'like', '%' . $title . '%')
        ->delete();
}

public function approveNews($id)
{
    $item = News::findOrFail($id);

    $item->update([
        'status' => 'approved',
        'approved_by' => auth()->id(),
        'approved_at' => now(),
        'rejection_reason' => null,
    ]);

    $this->removePendingNotification($item->title);

    Notification::create([
        'user_id' => $item->user_id,
        'sender_id' => auth()->id(),
        'type' => 'content_approved',
        'title' => 'تمت الموافقة على خبرك',
        'message' => 'تمت الموافقة على خبرك "' . $item->title . '" ونشره بنجاح.',
        'link' => route('news.index'),
        'is_read' => false,
    ]);

    return back()->with('success', 'تمت الموافقة على الخبر ونشره.');
}

public function rejectNews(Request $request, $id)
{
    $item = News::findOrFail($id);

    $reason = $request->input(
        'rejection_reason',
        'تم رفض الخبر من الإدارة.'
    );

    $item->update([
        'status' => 'rejected',
        'approved_by' => auth()->id(),
        'rejection_reason' => $reason,
    ]);

    $this->removePendingNotification($item->title);

    Notification::create([
        'user_id' => $item->user_id,
        'sender_id' => auth()->id(),
        'type' => 'content_rejected',
        'title' => 'تم رفض خبرك',
        'message' => 'تم رفض خبرك "' . $item->title . '". السبب: ' . $reason,
        'link' => route('news.index'),
        'is_read' => false,
    ]);

    return back()->with('success', 'تم رفض الخبر.');
}

public function approveAnnouncement($id)
{
    $item = Announcement::findOrFail($id);

    $item->update([
        'status' => 'approved',
        'approved_by' => auth()->id(),
        'approved_at' => now(),
        'rejection_reason' => null,
    ]);

    $this->removePendingNotification($item->title);

    Notification::create([
        'user_id' => $item->user_id,
        'sender_id' => auth()->id(),
        'type' => 'content_approved',
        'title' => 'تمت الموافقة على إعلانك',
        'message' => 'تمت الموافقة على إعلانك "' . $item->title . '" ونشره بنجاح.',
        'link' => route('announcements.index'),
        'is_read' => false,
    ]);

    return back()->with('success', 'تمت الموافقة على الإعلان ونشره.');
}

public function rejectAnnouncement(Request $request, $id)
{
    $item = Announcement::findOrFail($id);

    $reason = $request->input(
        'rejection_reason',
        'تم رفض الإعلان من الإدارة.'
    );

    $item->update([
        'status' => 'rejected',
        'approved_by' => auth()->id(),
        'rejection_reason' => $reason,
    ]);

    $this->removePendingNotification($item->title);

    Notification::create([
        'user_id' => $item->user_id,
        'sender_id' => auth()->id(),
        'type' => 'content_rejected',
        'title' => 'تم رفض إعلانك',
        'message' => 'تم رفض إعلانك "' . $item->title . '". السبب: ' . $reason,
        'link' => route('announcements.index'),
        'is_read' => false,
    ]);

    return back()->with('success', 'تم رفض الإعلان.');
}

public function approveProperty($id)
{
    $item = Property::findOrFail($id);

    $item->update([
        'status' => 'approved',
        'approved_by' => auth()->id(),
        'approved_at' => now(),
        'rejection_reason' => null,
    ]);

    $this->removePendingNotification($item->title);

    Notification::create([
        'user_id' => $item->user_id,
        'sender_id' => auth()->id(),
        'type' => 'content_approved',
        'title' => 'تمت الموافقة على عقارك',
        'message' => 'تمت الموافقة على عقارك "' . $item->title . '" ونشره بنجاح.',
        'link' => $item->type === 'sale'
            ? route('properties.sale')
            : route('properties.rent'),
        'is_read' => false,
    ]);

    return back()->with('success', 'تمت الموافقة على العقار ونشره.');
}

public function rejectProperty(Request $request, $id)
{
    $item = Property::findOrFail($id);

    $reason = $request->input(
        'rejection_reason',
        'تم رفض العقار من الإدارة.'
    );

    $item->update([
        'status' => 'rejected',
        'approved_by' => auth()->id(),
        'rejection_reason' => $reason,
    ]);

    $this->removePendingNotification($item->title);

    Notification::create([
        'user_id' => $item->user_id,
        'sender_id' => auth()->id(),
        'type' => 'content_rejected',
        'title' => 'تم رفض عقارك',
        'message' => 'تم رفض عقارك "' . $item->title . '". السبب: ' . $reason,
        'link' => $item->type === 'sale'
            ? route('properties.sale')
            : route('properties.rent'),
        'is_read' => false,
    ]);

    return back()->with('success', 'تم رفض العقار.');
}

    public function announcements()
    {
        $items = Announcement::with(['user', 'approver'])
            ->latest()
            ->paginate(20);

        return view('admin.announcements', compact('items'));
    }


    public function properties()
    {
        // صفحة الإدارة تعرض فقط العقارات التي تنتظر المراجعة
        $items = Property::with(['user', 'approver'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(20);

        return view('admin.properties', compact('items'));
    }




    public function comments()
    {
        $comments = ContentComment::with([
            'user',
            'commentable'
        ])
        ->latest()
        ->paginate(30);

        return view('admin.comments', compact('comments'));
    }

    public function approveComment($id)
    {
        ContentComment::findOrFail($id)->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'تمت الموافقة على التعليق.');
    }

    public function rejectComment($id)
    {
        ContentComment::findOrFail($id)->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'تم رفض التعليق.');
    }

}
