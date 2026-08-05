<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'active')
                          ->with(['user', 'category', 'likes'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);
        
        return view('products.index', compact('products'));
    }

    public function usedProducts()
    {
        $products = Product::where('status', 'active')
                          ->where(function($query) {
                              $query->where('condition', 'used')
                                    ->orWhere('condition', 'good')
                                    ->orWhere('condition', 'like_new')
                                    ->orWhere('condition', 'fair')
                                    ->orWhere('condition', 'excellent')
                                    ->orWhere('condition', 'very_good')
                                    ->orWhere('condition', 'مقبول')
                                    ->orWhere('condition', 'جيد')
                                    ->orWhere('condition', 'جيد جدا')
                                    ->orWhere('condition', 'ممتاز')
                                    ->orWhere('condition', 'بحال الجديد')
                                    ->orWhere('is_used', true);
                          })
                          ->with(['user', 'category', 'likes'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.used', compact('products'));
    }

    public function newProducts()
    {
        $products = Product::where('status', 'active')
                          ->where('condition', 'new')
                          ->with(['user', 'category', 'likes'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.new', compact('products'));
    }

public function toggleLike($id)
{
    try {
        $product = Product::findOrFail($id);
        $userId = Auth::id();
        
        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'يجب تسجيل الدخول أولاً'
            ], 401);
        }
        
        $like = Like::where('user_id', $userId)->where('product_id', $product->id)->first();
        
        if ($like) {
            // إذا كان موجوداً، نغير حالته
            $like->is_liked = !$like->is_liked;
            $like->save();
            $isLiked = $like->is_liked;
            $message = $isLiked ? 'تم الإعجاب بالمنتج' : 'تم إلغاء الإعجاب';
        } else {
            // إذا لم يكن موجوداً، ننشئ جديداً
            Like::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'is_liked' => true,
            ]);
            $isLiked = true;
            $message = 'تم الإعجاب بالمنتج';
        }
        
        $likesCount = $product->likes()->where('is_liked', true)->count();
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'likes_count' => $likesCount,
            'is_liked' => $isLiked,
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'حدث خطأ: ' . $e->getMessage()
        ], 500);
    }
}

    public function byCategory($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();
        
        if (!$category) {
            abort(404, 'التصنيف غير موجود');
        }

        $products = Product::where('category_id', $category->id)
                          ->where('status', 'active')
                          ->with(['user', 'category', 'likes'])
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('products.by-category', compact('products', 'category'));
    }

public function show($id)
{
    $product = Product::with(['user', 'category', 'likes'])->findOrFail($id);
    
    // زيادة عدد المشاهدات فقط عند التحميل الأول (وليس عند التحديث)
    // نستخدم session لتتبع ما إذا تمت مشاهدة المنتج بالفعل
    $sessionKey = 'viewed_product_' . $id;
    if (!session()->has($sessionKey)) {
        $product->increment('views');
        session()->put($sessionKey, true);
    }
    
    $canEdit = Auth::check() && Auth::id() === $product->user_id;

    $similarProducts = Product::where('category_id', $product->category_id)
                             ->where('id', '!=', $product->id)
                             ->where('status', 'active')
                             ->with(['user', 'category', 'likes'])
                             ->inRandomOrder()
                             ->take(4)
                             ->get();
    
    return view('products.show', compact('product', 'canEdit', 'similarProducts'));
}

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.show', $product->id)
                           ->with('error', 'ليس لديك صلاحية لتعديل هذا المنتج.');
        }
        
        $categories = Category::where('is_active', true)->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
            $product = Product::findOrFail($id);
    
    $this->authorize('update', $product);
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.show', $product->id)
                           ->with('error', 'ليس لديك صلاحية لتعديل هذا المنتج.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'condition' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        if ($request->has('category_id')) {
            $product->category_id = $request->category_id;
        }
        
        if ($request->has('condition')) {
            $product->condition = $request->condition;
            $product->is_used = ($request->condition !== 'new' && $request->condition !== 'جديد');
        }

        if ($request->has('quantity')) {
            $product->quantity = $request->quantity;
        }

        // حذف الصور المحددة
        if ($request->has('delete_images') && $request->delete_images) {
            $deleteImages = explode(',', $request->delete_images);
            $currentImages = [];
            if ($product->images) {
                $currentImages = json_decode($product->images, true);
                if (!is_array($currentImages)) {
                    $currentImages = [];
                }
            }
            
            foreach ($deleteImages as $imageToDelete) {
                if (in_array($imageToDelete, $currentImages)) {
                    Storage::disk('public')->delete($imageToDelete);
                    $currentImages = array_diff($currentImages, [$imageToDelete]);
                }
            }
            $product->images = !empty($currentImages) ? json_encode(array_values($currentImages)) : null;
        }

        if ($request->hasFile('images')) {
            $currentImages = [];
            if ($product->images) {
                $currentImages = json_decode($product->images, true);
                if (!is_array($currentImages)) {
                    $currentImages = [];
                }
            }
            
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $currentImages[] = $path;
            }
            
            $product->images = json_encode($currentImages);
        }

        $product->save();

        // تحديث التخفيضات المرتبطة
        if ($product->discounts) {
            foreach ($product->discounts as $discount) {
                $discount->updated_at = now();
                $discount->save();
            }
        }

        return redirect()->route('products.show', $product->id)
                        ->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->user_id !== Auth::id()) {
            return redirect()->route('products.show', $product->id)
                           ->with('error', 'ليس لديك صلاحية لحذف هذا المنتج.');
        }

        if ($product->images) {
            $images = json_decode($product->images, true);
            if (is_array($images)) {
                foreach ($images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();

        return redirect()->route('products.index')
                        ->with('success', 'تم حذف المنتج بنجاح.');
    }

    public function create()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً');
        }

        $user = Auth::user();
        
        if ($user->user_type === 'user') {
            return view('products.create-used');
        } elseif ($user->user_type === 'merchant' || $user->isServiceProvider()) {
            return view('products.create-new');
        } else {
            return redirect()->back()->with('error', 'ليس لديك صلاحية لإضافة منتجات.');
        }
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'condition' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->user_id = $user->id;
        $product->status = 'active';
        $product->quantity = $request->quantity ?? 1;

        if ($user->user_type === 'user') {
            $product->condition = $request->condition ?? 'used';
            $product->is_used = true;
        } else {
            $product->condition = $request->condition ?? 'new';
            $product->is_used = ($product->condition !== 'new' && $product->condition !== 'جديد');
        }

        // تعيين فئة افتراضية إذا لم يحدد المستخدم
        $category = Category::first();
        if ($category) {
            $product->category_id = $category->id;
        }

        if ($request->hasFile('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $imagePaths[] = $path;
            }
            $product->images = json_encode($imagePaths);
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح.');
    }
}
