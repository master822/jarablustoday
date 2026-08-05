<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use App\Models\Message;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MerchantDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->count();
        $discounts = Discount::where('merchant_id', $user->id)->count();
        $messages = Message::where('receiver_id', $user->id)->where('is_read', false)->count();
        $jobs = Job::where('user_id', $user->id)->count();
        
        return view('merchant.dashboard', compact('user', 'products', 'discounts', 'messages', 'jobs'));
    }

    public function myProducts()
    {
        $products = Product::where('user_id', Auth::id())->latest()->paginate(12);
        return view('merchant.products', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::where('is_active', true)->get();
        return view('products.create-new', compact('categories'));
    }

public function storeProduct(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'condition' => 'nullable|string|max:255',
        'quantity' => 'nullable|integer|min:1',
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
    $product->quantity = $request->quantity ?? 1;
    $product->condition = $request->condition ?? 'new';
    $product->category_id = $category->id;
    $product->user_id = $user->id;
    $product->is_used = false;
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

    return redirect()->route('merchant.products')->with('success', 'تم إضافة المنتج بنجاح');
}

    public function editProduct($id)
    {
        $product = Product::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $categories = Category::where('is_active', true)->get();
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
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;

        if ($request->hasFile('images')) {
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

        return redirect()->route('merchant.products')->with('success', 'تم تحديث المنتج بنجاح');
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
        return redirect()->route('merchant.products')->with('success', 'تم حذف المنتج بنجاح');
    }

    public function discounts()
    {
        $discounts = Discount::where('merchant_id', Auth::id())->latest()->paginate(10);
        return view('merchant.discounts', compact('discounts'));
    }

    public function createDiscount()
    {
        $products = Product::where('user_id', Auth::id())->get();
        return view('merchant.create-discount', compact('products'));
    }

public function storeDiscount(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'percentage' => 'required|numeric|min:1|max:100',
        'product_id' => 'required|exists:products,id',
    ]);

    $product = Product::where('id', $request->product_id)->where('user_id', Auth::id())->firstOrFail();

    Discount::create([
        'name' => $request->name,
        'description' => $request->description,
        'percentage' => $request->percentage,
        'is_active' => true,
        'product_id' => $product->id,
        'merchant_id' => Auth::id(),
        'start_date' => now(),
        'end_date' => now()->addDays(30),
    ]);

    return redirect()->route('merchant.discounts')->with('success', 'تم إنشاء التخفيض بنجاح');
}
public function editDiscount($id)
{
    $discount = Discount::where('id', $id)->where('merchant_id', Auth::id())->firstOrFail();
    return view('merchant.edit-discount', compact('discount'));
}

public function updateDiscount(Request $request, $id)
{
    $discount = Discount::where('id', $id)->where('merchant_id', Auth::id())->firstOrFail();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'percentage' => 'required|numeric|min:1|max:100',
    ]);

    $discount->update([
        'name' => $request->name,
        'description' => $request->description,
        'percentage' => $request->percentage,
    ]);

    return redirect()->route('merchant.discounts')->with('success', 'تم تحديث التخفيض بنجاح');
}
    public function deleteDiscount($id)
    {
        $discount = Discount::where('id', $id)->where('merchant_id', Auth::id())->firstOrFail();
        $discount->delete();
        return redirect()->route('merchant.discounts')->with('success', 'تم حذف التخفيض بنجاح');
    }

    public function messages()
    {
        $messages = Message::where('receiver_id', Auth::id())
                          ->with('sender')
                          ->latest()
                          ->paginate(20);
        return view('merchant.messages', compact('messages'));
    }

    public function markMessageRead($id)
    {
        $message = Message::where('id', $id)->where('receiver_id', Auth::id())->firstOrFail();
        $message->is_read = true;
        $message->save();
        return back()->with('success', 'تم قراءة الرسالة');
    }

    // إدارة الوظائف
    public function jobs()
    {
        $jobs = Job::where('user_id', Auth::id())->latest()->paginate(10);
        return view('merchant.jobs', compact('jobs'));
    }

    public function createJob()
    {
        return view('merchant.create-job');
    }

    public function storeJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:full_time,part_time,freelance,temporary',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_type' => 'required|in:hourly,daily,weekly,monthly,yearly',
            'expires_at' => 'nullable|date|after:today',
        ]);

        Job::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'salary_type' => $request->salary_type,
            'is_active' => true,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('merchant.jobs')->with('success', 'تم نشر فرصة العمل بنجاح');
    }

    public function editJob($id)
    {
        $job = Job::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('merchant.edit-job', compact('job'));
    }

    public function updateJob(Request $request, $id)
    {
        $job = Job::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:full_time,part_time,freelance,temporary',
            'location' => 'nullable|string|max:255',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'salary_type' => 'required|in:hourly,daily,weekly,monthly,yearly',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date',
        ]);

        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'salary_type' => $request->salary_type,
            'is_active' => $request->has('is_active'),
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('merchant.jobs')->with('success', 'تم تحديث فرصة العمل بنجاح');
    }

    public function deleteJob($id)
    {
        $job = Job::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $job->delete();
        return redirect()->route('merchant.jobs')->with('success', 'تم حذف فرصة العمل بنجاح');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('merchant.profile', compact('user'));
    }

public function updateProfile(Request $request)
{
    $user = Auth::user();
    
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'city' => 'nullable|string|max:255',
        'store_name' => 'nullable|string|max:255',
        'store_description' => 'nullable|string',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'store_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $user->name = $request->name;
    $user->phone = $request->phone;
    $user->city = $request->city;
    $user->store_name = $request->store_name;
    $user->store_description = $request->store_description;

    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    if ($request->hasFile('store_logo')) {
        if ($user->store_logo) {
            Storage::disk('public')->delete($user->store_logo);
        }
        $path = $request->file('store_logo')->store('store-logos', 'public');
        $user->store_logo = $path;
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
