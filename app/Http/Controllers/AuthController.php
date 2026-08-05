<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->user_type == 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->user_type == 'merchant') {
                return redirect('/merchant/dashboard');
            } elseif ($user->user_type == 'service_provider' || $user->user_type == 'other') {
                return redirect('/service-provider/dashboard');
            }
            return redirect('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string',
            'city' => 'required|string',
            'password' => 'required|min:8|confirmed',
            'user_type' => 'required|in:user,merchant,service_provider'
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'password' => Hash::make($request->password),
            'user_type' => $request->user_type,
            'is_active' => true,
            'product_limit' => 20
        ];

        // إضافة حقول إضافية للتاجر
        if ($request->user_type == 'merchant') {
            $userData['store_category'] = $request->store_category;
            $userData['store_description'] = $request->store_description;
        }

        $user = User::create($userData);

        // إنشاء سجل خدمة لمقدم الخدمات
        if ($request->user_type == 'service_provider') {
            Service::create([
                'user_id' => $user->id,
                'service_type' => $request->service_type ?? 'other',
                'service_name' => $request->name . ' - خدمات',
                'description' => $request->service_description,
                'city' => $request->city,
                'is_active' => true
            ]);
        }

        Auth::login($user);

        if ($user->user_type == 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->user_type == 'merchant') {
            return redirect('/merchant/dashboard');
        } elseif ($user->user_type == 'service_provider' || $user->user_type == 'other') {
            return redirect('/service-provider/dashboard');
        }
        return redirect('/user/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
