<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\PaymentRequest;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // عرض خطط الاشتراك
    public function plans()
    {
        $user = Auth::user();
        $subscription = Subscription::where('user_id', $user->id)
                                   ->where('status', 'active')
                                   ->first();
        
        $plans = [
            [
                'name' => 'الباقة المتوسطة',
                'key' => 'medium',
                'price' => 10,
                'product_limit' => 80,
                'color' => 'bronze',
                'icon' => 'fa-crown',
                'features' => [
                    '80 منتج',
                    'دعم فني',
                    'إحصائيات متقدمة',
                ]
            ],
            [
                'name' => 'الباقة الذهبية',
                'key' => 'gold',
                'price' => 20,
                'product_limit' => 200,
                'color' => 'gold',
                'icon' => 'fa-crown',
                'features' => [
                    '200 منتج',
                    'دعم فني أولوية',
                    'إحصائيات متقدمة',
                    'تخفيضات حصرية',
                ]
            ],
        ];

        return view('subscription.plans', compact('plans', 'subscription'));
    }

    // عرض صفحة الدفع
    public function checkout($plan)
    {
        $plans = [
            'medium' => ['name' => 'الباقة المتوسطة', 'price' => 10, 'product_limit' => 80],
            'gold' => ['name' => 'الباقة الذهبية', 'price' => 20, 'product_limit' => 200],
        ];

        if (!isset($plans[$plan])) {
            return redirect()->route('subscription.plans')->with('error', 'الباقة غير موجودة');
        }

        $planData = $plans[$plan];
        $paymentCode = 'ba64858e96d4ad9c6096948bc2dbc970'; // رمز Shamcach

        return view('subscription.checkout', compact('planData', 'paymentCode', 'plan'));
    }

    // معالجة الدفع
    public function processPayment(Request $request, $plan)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $plans = [
            'medium' => ['name' => 'الباقة المتوسطة', 'price' => 10, 'product_limit' => 80],
            'gold' => ['name' => 'الباقة الذهبية', 'price' => 20, 'product_limit' => 200],
        ];

        if (!isset($plans[$plan])) {
            return redirect()->route('subscription.plans')->with('error', 'الباقة غير موجودة');
        }

        // حفظ إثبات الدفع
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        // إنشاء طلب دفع
        $paymentRequest = PaymentRequest::create([
            'user_id' => $user->id,
            'plan' => $plan,
            'amount' => $plans[$plan]['price'],
            'payment_proof' => $path,
            'status' => 'pending',
        ]);

        // إرسال إشعار للمسؤول
        $admins = User::where('user_type', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'sender_id' => $user->id,
                'type' => 'payment',
                'title' => 'طلب اشتراك جديد',
                'message' => 'المستخدم ' . $user->name . ' طلب اشتراك في الباقة ' . $plans[$plan]['name'],
                'link' => route('admin.payments'),
                'is_read' => false,
            ]);
        }

        // إشعار للمستخدم
        Notification::create([
            'user_id' => $user->id,
            'sender_id' => $user->id,
            'type' => 'payment',
            'title' => 'تم إرسال طلب الاشتراك',
            'message' => 'سيتم تفعيل باقة ' . $plans[$plan]['name'] . ' خلال 24 ساعة',
            'link' => route('subscription.plans'),
            'is_read' => false,
        ]);

        return redirect()->route('subscription.plans')
                        ->with('success', 'تم إرسال طلب الاشتراك بنجاح. سيتم تفعيله خلال 24 ساعة');
    }

    // لوحة تحكم المسؤول للاشتراكات
    public function adminPayments()
    {
        $paymentRequests = PaymentRequest::with(['user'])
                                        ->orderBy('created_at', 'desc')
                                        ->paginate(20);
        
        return view('admin.payments', compact('paymentRequests'));
    }

    // الموافقة على طلب الدفع
    public function approvePayment($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        $paymentRequest->status = 'approved';
        $paymentRequest->save();

        // إنشاء اشتراك للمستخدم
        $plans = [
            'medium' => ['product_limit' => 80],
            'gold' => ['product_limit' => 200],
        ];

        $subscription = Subscription::create([
            'user_id' => $paymentRequest->user_id,
            'plan' => $paymentRequest->plan,
            'product_limit' => $plans[$paymentRequest->plan]['product_limit'],
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'active',
            'activated_at' => now(),
        ]);

        // تحديث product_limit في جدول المستخدمين
        $user = User::find($paymentRequest->user_id);
        $user->product_limit = $plans[$paymentRequest->plan]['product_limit'];
        $user->save();

        // إرسال إشعار للمستخدم
        Notification::create([
            'user_id' => $paymentRequest->user_id,
            'sender_id' => auth()->id(),
            'type' => 'subscription',
            'title' => 'تم تفعيل اشتراكك',
            'message' => 'تم تفعيل اشتراكك في الباقة ' . $paymentRequest->plan . ' اعتباراً من اليوم ولمدة شهر واحد',
            'link' => route('subscription.plans'),
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'تم تفعيل الاشتراك بنجاح');
    }

    // رفض طلب الدفع
    public function rejectPayment($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        $paymentRequest->status = 'rejected';
        $paymentRequest->save();

        return redirect()->back()->with('success', 'تم رفض طلب الدفع');
    }

    // التحقق من صلاحية الاشتراك
    public function checkSubscription()
    {
        $user = Auth::user();
        
        // التحقق من الفترة المجانية للمستخدمين الجدد
        if ($user->subscription_trial_start === null) {
            $user->subscription_trial_start = now();
            $user->subscription_trial_end = now()->addMonths(4);
            $user->save();
        }

        $subscription = Subscription::where('user_id', $user->id)
                                   ->where('status', 'active')
                                   ->first();

        return response()->json([
            'has_active_subscription' => $subscription && $subscription->isActive(),
            'is_on_trial' => $user->subscription_trial_end && $user->subscription_trial_end >= now(),
            'trial_days_left' => $user->subscription_trial_end ? now()->diffInDays($user->subscription_trial_end) : 0,
            'product_limit' => $subscription ? $subscription->product_limit : 25,
        ]);
    }
}
