<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchantController extends Controller
{
    public function index()
    {
        $merchants = User::where('user_type', 'merchant')
                        ->where('is_active', 1)
                        ->with(['ratings', 'products'])
                        ->paginate(20);
        
        return response()->json([
            'success' => true,
            'data' => $merchants
        ]);
    }

    public function show($id)
    {
        $merchant = User::where('user_type', 'merchant')
                       ->with(['ratings', 'products'])
                       ->find($id);
        
        if (!$merchant) {
            return response()->json([
                'success' => false,
                'message' => 'التاجر غير موجود'
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'data' => $merchant
        ]);
    }
}
