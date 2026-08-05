<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = User::where(function($query) {
                            $query->where('user_type', 'merchant')
                                  ->orWhere('user_type', 'service_provider');
                        })
                        ->where('is_active', true)
                        ->with('products')
                        ->paginate(20);
        return view('merchants.index', compact('merchants'));
    }

    public function show($id)
    {
        $merchant = User::with(['products', 'products.category', 'services'])
                       ->findOrFail($id);
        
        // السماح لكل من merchant و service_provider
        if (!in_array($merchant->user_type, ['merchant', 'service_provider'])) {
            abort(404, 'هذا المستخدم ليس تاجراً أو مقدم خدمات');
        }
        
        return view('merchants.show', compact('merchant'));
    }

    public function byCategory($category)
    {
        $merchants = User::where(function($query) {
                            $query->where('user_type', 'merchant')
                                  ->orWhere('user_type', 'service_provider');
                        })
                        ->where('store_category', $category)
                        ->where('is_active', true)
                        ->paginate(20);
        return view('merchants.category', compact('merchants', 'category'));
    }
}
