<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function discounts()
    {
        $discounts = Discount::where('is_active', 1)
                           ->with(['product', 'merchant'])
                           ->orderBy('created_at', 'desc')
                           ->paginate(12);
        
        return view('discounts.index', compact('discounts'));
    }

    public function show($id)
    {
        $discount = Discount::with(['product', 'merchant'])->findOrFail($id);
        return view('discounts.show', compact('discount'));
    }

    public function categoryDiscounts($categorySlug)
    {
        // يمكن إضافة فلتر حسب التصنيف لاحقاً
        $discounts = Discount::where('is_active', 1)
                           ->with(['product', 'merchant'])
                           ->whereHas('product', function($query) use ($categorySlug) {
                               $query->where('category', $categorySlug);
                           })
                           ->paginate(12);
        
        return view('discounts.index', compact('discounts'));
    }
}
