<?php

namespace App\Http\Controllers\Api;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::where('is_active', 1)
                           ->with(['product', 'merchant'])
                           ->paginate(20);
        
        return response()->json([
            'success' => true,
            'data' => $discounts
        ]);
    }

    public function show($id)
    {
        $discount = Discount::with(['product', 'merchant'])->find($id);
        
        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'التخفيض غير موجود'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $discount
        ]);
    }
}
