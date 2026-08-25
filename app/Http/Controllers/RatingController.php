<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /**
     * الكلمات الممنوعة في التعليقات
     */
    private $bannedWords = [
        'ايري',
        'بكسها',
        'ايري بيها',
        'يلعن',
        'انيكك',
        'كس امك',
        'خرقها',
        'يلعن تبعها',

        'fuck',
        'shit',
        'asshole',
        'bitch',
        'dick',
        'pussy',
        'motherfucker',

        'قحبة',
        'شرموطة',
        'عاهر',
        'زانية',
        'كلب',
        'حمار'
    ];

    /**
     * إضافة تقييم جديد لمنتج وتاجر
     */
    public function store(Request $request)
    {
        // التأكد من تسجيل الدخول
        if (!Auth::check()) {
            return back()->with('error', 'يجب تسجيل الدخول أولاً.');
        }

        // التأكد أن المستخدم مستخدم عادي وليس تاجر أو مدير
        if (Auth::user()->user_type !== 'user') {
            return back()->with(
                'error',
                'يمكن للمستخدمين العاديين فقط تقييم المنتجات.'
            );
        }

        // التحقق من البيانات
        $request->validate([
            'merchant_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:5|max:500',
        ]);

        // التأكد أن merchant_id يعود إلى تاجر فعلاً
        $merchant = User::where('id', $request->merchant_id)
            ->where('user_type', 'merchant')
            ->first();

        if (!$merchant) {
            return back()->with('error', 'التاجر غير موجود.');
        }

        // الحصول على المنتج
        $product = Product::find($request->product_id);

        if (!$product) {
            return back()->with('error', 'المنتج غير موجود.');
        }

        // التأكد أن المنتج تابع للتاجر المحدد
        if ((int) $product->user_id !== (int) $merchant->id) {
            return back()->with(
                'error',
                'هذا المنتج لا يتبع للتاجر المحدد.'
            );
        }

        // منع المستخدم من تقييم نفس المنتج أكثر من مرة
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingRating) {
            return back()->with(
                'error',
                'لقد قمت بتقييم هذا المنتج مسبقاً.'
            );
        }

        // فحص التعليق
        $moderationResult = $this->moderateComment(
            $request->comment
        );

        // إنشاء التقييم
        Rating::create([
            'user_id' => Auth::id(),
            'merchant_id' => $merchant->id,
            'product_id' => $product->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => $moderationResult['approved'],
            'is_flagged' => $moderationResult['flagged'],
            'moderation_reason' => $moderationResult['reason'],
        ]);

        return back()->with(
            'success',
            'تم إضافة التقييم بنجاح ' .
            ($moderationResult['approved']
                ? ''
                : '(بانتظار المراجعة)')
        );
    }

    /**
     * فحص التعليق بحثاً عن الكلمات الممنوعة
     */
    private function moderateComment($comment)
    {
        $commentLower = mb_strtolower(
            $comment,
            'UTF-8'
        );

        $foundWords = [];

        foreach ($this->bannedWords as $word) {
            if (
                mb_strpos(
                    $commentLower,
                    mb_strtolower($word, 'UTF-8')
                ) !== false
            ) {
                $foundWords[] = $word;
            }
        }

        if (!empty($foundWords)) {
            return [
                'approved' => false,
                'flagged' => true,
                'reason' => implode(', ', $foundWords),
            ];
        }

        return [
            'approved' => true,
            'flagged' => false,
            'reason' => null,
        ];
    }

    /**
     * الحصول على تقييمات تاجر
     */
    public function index($merchantId)
    {
        $ratings = Rating::where('merchant_id', $merchantId)
            ->where('is_approved', true)
            ->with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $average = Rating::where('merchant_id', $merchantId)
            ->where('is_approved', true)
            ->avg('rating');

        return response()->json([
            'ratings' => $ratings,
            'average' => round($average ?? 0, 1),
            'count' => $ratings->count(),
        ]);
    }

    /**
     * الحصول على تقييمات تاجر
     */
    public function getMerchantRatings($merchantId)
    {
        $ratings = Rating::where('merchant_id', $merchantId)
            ->where('is_approved', true)
            ->with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        $averageRating = $ratings->avg('rating');
        $totalRatings = $ratings->count();

        return [
            'ratings' => $ratings,
            'average_rating' => round($averageRating ?? 0, 1),
            'total_ratings' => $totalRatings,
        ];
    }

    /**
     * الحصول على تقييمات منتج محدد
     */
    public function productRatings($productId)
    {
        $ratings = Rating::where('product_id', $productId)
            ->where('is_approved', true)
            ->with(['user', 'merchant'])
            ->orderBy('created_at', 'desc')
            ->get();

        $average = $ratings->avg('rating');

        return response()->json([
            'ratings' => $ratings,
            'average' => round($average ?? 0, 1),
            'count' => $ratings->count(),
        ]);
    }
}