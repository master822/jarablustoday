<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->latest()->paginate(10);
        $messages = Message::where('receiver_id', $user->id)->where('is_read', false)->count();
        
        return view('user.dashboard', compact('user', 'products', 'messages'));
    }

    public function myProducts()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->latest()->paginate(12);
        return view('user.products', compact('products'));
    }

    public function createProduct()
    {
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('products.create-used', compact('categories'));
    }

public function storeProduct(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'condition' => 'required|string|max:255',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::user();

    // التحقق من وجود فئة
    $category = \App\Models\Category::first();
    if (!$category) {
        $category = \App\Models\Category::create([
            'name' => 'منتجات عامة',
            'slug' => 'general',
            'is_active' => 1,
        ]);
    }
    
    $product = new Product();
    $product->name = $request->name;
    $product->description = $request->description;
    $product->price = $request->price;
    $product->condition = $request->condition;
    $product->category_id = $category->id;
    $product->user_id = $user->id;
    $product->is_used = true;
    $product->status = 'active';

    if ($request->hasFile('images')) {
        $imagePaths = [];
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $imagePaths[] = $path;
        }
        $product->images = json_encode($imagePaths);
    }

    $product->save();

    return redirect()->route('user.products')->with('success', 'تم إضافة المنتج بنجاح');
}

    public function editProduct($id)
    {
        $product = Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $categories = \App\Models\Category::where('is_active', true)->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->condition = $request->condition;

        if ($request->hasFile('images')) {
            // حذف الصور القديمة
            if ($product->images) {
                $oldImages = json_decode($product->images, true);
                if (is_array($oldImages)) {
                    foreach ($oldImages as $image) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }
            
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
            $product->images = json_encode($imagePaths);
        }

        $product->save();

        return redirect()->route('user.products')->with('success', 'تم تحديث المنتج بنجاح');
    }

    public function deleteProduct($id)
    {
        $product = Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        if ($product->images) {
            $images = json_decode($product->images, true);
            if (is_array($images)) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }
        
        $product->delete();
        return redirect()->route('user.products')->with('success', 'تم حذف المنتج بنجاح');
    }

    public function messages()
    {
        $messages = Message::where('receiver_id', Auth::id())
                          ->with('sender')
                          ->latest()
                          ->paginate(20);
        return view('user.messages', compact('messages'));
    }

    public function markMessageRead($id)
    {
        $message = Message::where('id', $id)->where('receiver_id', Auth::id())->firstOrFail();
        $message->is_read = true;
        $message->save();
        return back()->with('success', 'تم قراءة الرسالة');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
public function updateProfile(Request $request)
{
    $user = Auth::user();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'city' => 'nullable|string|max:255',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->city = $request->city;

    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    $user->save();

    return back()->with('success', 'تم تحديث الملف الشخصي بنجاح');
}

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}
