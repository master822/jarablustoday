<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Property;
use App\Models\Category;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;

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


    /**
     * جميع منشورات المستخدم:
     * أخبار + إعلانات + عقارات + منتجات.
     */
    public function myPosts(Request $request)
    {
        $userId = Auth::id();

        $posts = collect();

        // الأخبار
        $news = News::where('user_id', $userId)
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->post_type = 'news';
                $item->post_type_label = 'خبر';
                $item->post_title = $item->title;
                $item->post_description = $item->content;
                $item->post_status = $item->status;
                $item->post_url = route('news.show', $item->id);
                return $item;
            });

        // الإعلانات
        $announcements = Announcement::where('user_id', $userId)
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->post_type = 'announcement';
                $item->post_type_label = 'إعلان';
                $item->post_title = $item->title;
                $item->post_description = $item->content;
                $item->post_status = $item->status;
                $item->post_url = route('announcements.show', $item->id);
                return $item;
            });

        // العقارات
        $properties = Property::where('user_id', $userId)
            ->withCount(['likes', 'comments'])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->post_type = 'property';
                $item->post_type_label = 'عقار';
                $item->post_title = $item->title;
                $item->post_description = $item->description;
                $item->post_status = $item->status;
                $item->post_url = route('properties.show', $item->id);
                return $item;
            });

        // المنتجات
        $products = Product::where('user_id', $userId)
            ->withCount([
                'likes as active_likes_count' => function ($q) {
                    $q->where('is_liked', true);
                }
            ])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->post_type = 'product';
                $item->post_type_label = 'منتج';
                $item->post_title = $item->name;
                $item->post_description = $item->description;
                $item->post_status = $item->status;
                $item->post_url = route('products.show', $item->id);
                $item->likes_count = $item->active_likes_count ?? 0;
                $item->comments_count = 0;
                return $item;
            });

        $posts = $posts
            ->merge($news)
            ->merge($announcements)
            ->merge($properties)
            ->merge($products)
            ->sortByDesc('created_at')
            ->values();

        // فلترة النوع
        $type = $request->get('type');

        if (in_array($type, ['news', 'announcement', 'property', 'product'], true)) {
            $posts = $posts
                ->filter(fn ($post) => $post->post_type === $type)
                ->values();
        }

        // Pagination موحدة
        $perPage = 12;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $items = $posts->slice(($page - 1) * $perPage, $perPage)->values();

        $posts = new LengthAwarePaginator(
            $items,
            $posts->count(),
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        return view('user.my-posts', compact('posts', 'type'));
    }

    /**
     * صفحة تعديل المنشور.
     */
    public function editPost($type, $id)
    {
        $userId = Auth::id();

        if ($type === 'product') {
            return redirect()->route('user.products.edit', $id);
        }

        $modelClass = match ($type) {
            'news' => News::class,
            'announcement' => Announcement::class,
            'property' => Property::class,
            default => abort(404),
        };

        $post = $modelClass::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        return view('user.edit-post', compact('post', 'type'));
    }

    /**
     * تحديث منشور المستخدم.
     */
    public function updatePost(Request $request, $type, $id)
    {
        $userId = Auth::id();

        if ($type === 'product') {
            return redirect()->route('user.products.edit', $id);
        }

        if ($type === 'news') {
            $post = News::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string|min:10',
                'image' => 'nullable|image|max:4096',
            ]);

            $post->title = $request->title;
            $post->content = $request->content;

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }

                $post->image = $request->file('image')
                    ->store('news', 'public');
            }

            // التعديل يعيد المنشور للمراجعة
            $post->status = 'pending';
            $post->approved_by = null;
            $post->approved_at = null;

            $post->save();

            return redirect()
                ->route('user.posts')
                ->with('success', 'تم تعديل الخبر وإرساله للمراجعة.');
        }

        if ($type === 'announcement') {
            $post = Announcement::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string|min:5',
                'phone' => 'nullable|string|max:30',
                'city' => 'nullable|string|max:100',
                'image' => 'nullable|image|max:4096',
            ]);

            $post->title = $request->title;
            $post->content = $request->content;
            $post->phone = $request->phone;
            $post->city = $request->city;

            if ($request->hasFile('image')) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }

                $post->image = $request->file('image')
                    ->store('announcements', 'public');
            }

            $post->status = 'pending';
            $post->approved_by = null;
            $post->approved_at = null;

            $post->save();

            return redirect()
                ->route('user.posts')
                ->with('success', 'تم تعديل الإعلان وإرساله للمراجعة.');
        }

        if ($type === 'property') {
            $post = Property::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            $request->validate([
                'type' => 'required|in:sale,rent',
                'title' => 'required|string|max:255',
                'description' => 'required|string|min:10',
                'price' => 'required|numeric|min:0',
                'city' => 'required|string|max:100',
                'area' => 'nullable|string|max:100',
                'address' => 'nullable|string|max:255',
                'rooms' => 'nullable|integer|min:0',
                'bathrooms' => 'nullable|integer|min:0',
                'area_m2' => 'required|numeric|min:1',
                'building_age' => 'nullable|integer|min:0|max:300',
                'finishing_type' => 'nullable|string|max:100',
            ]);

            $post->type = $request->type;
            $post->title = $request->title;
            $post->description = $request->description;
            $post->price = $request->price;
            $post->city = $request->city;
            $post->area = $request->area;
            $post->address = $request->address;
            $post->rooms = $request->rooms;
            $post->bathrooms = $request->bathrooms;
            $post->area_m2 = $request->area_m2;
            $post->building_age = $request->building_age;
            $post->finishing_type = $request->finishing_type;

            $post->status = 'pending';
            $post->approved_by = null;
            $post->approved_at = null;

            $post->save();

            return redirect()
                ->route('user.posts')
                ->with('success', 'تم تعديل العقار وإرساله للمراجعة.');
        }

        abort(404);
    }

    /**
     * حذف منشور يملكه المستخدم فقط.
     */
    public function deletePost($type, $id)
    {
        $userId = Auth::id();

        if ($type === 'product') {
            return $this->deleteProduct($id);
        }

        if ($type === 'news') {
            $post = News::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $post->delete();

            return back()->with('success', 'تم حذف الخبر بنجاح.');
        }

        if ($type === 'announcement') {
            $post = Announcement::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $post->delete();

            return back()->with('success', 'تم حذف الإعلان بنجاح.');
        }

        if ($type === 'property') {
            $post = Property::where('id', $id)
                ->where('user_id', $userId)
                ->firstOrFail();

            if (is_array($post->images)) {
                foreach ($post->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $post->delete();

            return back()->with('success', 'تم حذف العقار بنجاح.');
        }

        abort(404);
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
