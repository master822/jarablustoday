<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Discount;

class SearchController extends Controller
{
    // بحث المنتجات المتقدم
    public function searchProducts(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $condition = $request->get('condition');
        $sort = $request->get('sort', 'latest');
        
        $products = Product::query()
            ->where('status', 'active')
            ->when($query, function($q) use ($query) {
                // البحث في الاسم والوصف واسم البائع
                return $q->where(function($subQuery) use ($query) {
                    // البحث في اسم المنتج (بحث جزئي)
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                             // البحث في وصف المنتج
                             ->orWhere('description', 'LIKE', "%{$query}%")
                             // البحث في اسم البائع من خلال العلاقة
                             ->orWhereHas('user', function($userQuery) use ($query) {
                                 $userQuery->where('name', 'LIKE', "%{$query}%")
                                           ->orWhere('store_name', 'LIKE', "%{$query}%");
                             });
                });
            })
            ->when($category, function($q) use ($category) {
                return $q->where('category_id', $category);
            })
            ->when($minPrice, function($q) use ($minPrice) {
                return $q->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function($q) use ($maxPrice) {
                return $q->where('price', '<=', $maxPrice);
            })
            ->when($condition, function($q) use ($condition) {
                return $q->where('condition', $condition);
            })
            ->when($sort == 'latest', function($q) {
                return $q->orderBy('created_at', 'desc');
            })
            ->when($sort == 'price_low', function($q) {
                return $q->orderBy('price', 'asc');
            })
            ->when($sort == 'price_high', function($q) {
                return $q->orderBy('price', 'desc');
            })
            ->with(['user', 'category'])
            ->paginate(12);
        
        $categories = Category::where('is_active', 1)->get();
        
        return view('search.products', compact('products', 'categories', 'query', 'category', 'minPrice', 'maxPrice', 'condition', 'sort'));
    }
    
    // بحث التجار
    public function searchMerchants(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');
        $sort = $request->get('sort', 'latest');
        
        $merchants = User::where('user_type', 'merchant')
            ->where('is_active', 1)
            ->when($query, function($q) use ($query) {
                return $q->where(function($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                             ->orWhere('store_name', 'LIKE', "%{$query}%")
                             ->orWhere('city', 'LIKE', "%{$query}%")
                             ->orWhere('store_description', 'LIKE', "%{$query}%");
                });
            })
            ->when($category, function($q) use ($category) {
                return $q->whereHas('products', function($query) use ($category) {
                    $query->where('category_id', $category);
                });
            })
            ->when($sort == 'latest', function($q) {
                return $q->orderBy('created_at', 'desc');
            })
            ->when($sort == 'name', function($q) {
                return $q->orderBy('name', 'asc');
            })
            ->with(['products' => function($q) {
                $q->with('category')->limit(5);
            }])
            ->paginate(12);
        
        $categories = Category::where('is_active', 1)->get();
        
        return view('search.merchants', compact('merchants', 'categories', 'query', 'category', 'sort'));
    }
    
    // بحث التخفيضات
    public function searchDiscounts(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');
        $minDiscount = $request->get('min_discount');
        $maxDiscount = $request->get('max_discount');
        $sort = $request->get('sort', 'latest');
        
        $discounts = Discount::query()
            ->where('is_active', 1)
            ->when($query, function($q) use ($query) {
                return $q->where(function($subQuery) use ($query) {
                    $subQuery->where('name', 'LIKE', "%{$query}%")
                             ->orWhere('description', 'LIKE', "%{$query}%")
                             ->orWhereHas('product', function($productQuery) use ($query) {
                                 $productQuery->where('name', 'LIKE', "%{$query}%")
                                              ->orWhere('description', 'LIKE', "%{$query}%");
                             })
                             ->orWhereHas('merchant', function($merchantQuery) use ($query) {
                                 $merchantQuery->where('name', 'LIKE', "%{$query}%")
                                               ->orWhere('store_name', 'LIKE', "%{$query}%");
                             });
                });
            })
            ->when($category, function($q) use ($category) {
                return $q->whereHas('product', function($query) use ($category) {
                    $query->where('category_id', $category);
                });
            })
            ->when($minDiscount, function($q) use ($minDiscount) {
                return $q->where('percentage', '>=', $minDiscount);
            })
            ->when($maxDiscount, function($q) use ($maxDiscount) {
                return $q->where('percentage', '<=', $maxDiscount);
            })
            ->when($sort == 'latest', function($q) {
                return $q->orderBy('created_at', 'desc');
            })
            ->when($sort == 'discount_high', function($q) {
                return $q->orderBy('percentage', 'desc');
            })
            ->with(['product', 'merchant'])
            ->paginate(12);
        
        $categories = Category::where('is_active', 1)->get();
        
        return view('search.discounts', compact('discounts', 'categories', 'query', 'category', 'minDiscount', 'maxDiscount', 'sort'));
    }
    
    // بحث المنتجات المستعملة
public function searchUsedProducts(Request $request)
{
    $query = $request->get('q');
    $category = $request->get('category');
    $minPrice = $request->get('min_price');
    $maxPrice = $request->get('max_price');
    $condition = $request->get('condition');
    $sort = $request->get('sort', 'latest');
    
    $products = Product::query()
        ->where('status', 'active')
        ->where(function($q) {
            // البحث عن جميع المنتجات المستعملة (بغض النظر عن التصنيف)
            $q->where('condition', 'used')
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
        ->when($query, function($q) use ($query) {
            return $q->where(function($subQuery) use ($query) {
                $subQuery->where('name', 'LIKE', "%{$query}%")
                         ->orWhere('description', 'LIKE', "%{$query}%")
                         ->orWhereHas('user', function($userQuery) use ($query) {
                             $userQuery->where('name', 'LIKE', "%{$query}%")
                                       ->orWhere('store_name', 'LIKE', "%{$query}%");
                         });
            });
        })
        ->when($category, function($q) use ($category) {
            return $q->where('category_id', $category);
        })
        ->when($minPrice, function($q) use ($minPrice) {
            return $q->where('price', '>=', $minPrice);
        })
        ->when($maxPrice, function($q) use ($maxPrice) {
            return $q->where('price', '<=', $maxPrice);
        })
        ->when($condition, function($q) use ($condition) {
            return $q->where('condition', $condition);
        })
        ->when($sort == 'latest', function($q) {
            return $q->orderBy('created_at', 'desc');
        })
        ->when($sort == 'price_low', function($q) {
            return $q->orderBy('price', 'asc');
        })
        ->when($sort == 'price_high', function($q) {
            return $q->orderBy('price', 'desc');
        })
        ->with(['user', 'category'])
        ->paginate(12);
    
    $categories = Category::where('is_active', 1)->get();
    
    return view('search.used-products', compact('products', 'categories', 'query', 'category', 'minPrice', 'maxPrice', 'condition', 'sort'));
}
    
    // بحث الخدمات
    public function searchServices(Request $request)
    {
        $query = $request->get('q');
        $serviceType = $request->get('service_type');
        $city = $request->get('city');
        $sort = $request->get('sort', 'latest');
        
        $services = \App\Models\Service::query()
            ->where('is_active', 1)
            ->when($query, function($q) use ($query) {
                return $q->where(function($subQuery) use ($query) {
                    $subQuery->where('service_name', 'LIKE', "%{$query}%")
                             ->orWhere('description', 'LIKE', "%{$query}%")
                             ->orWhere('city', 'LIKE', "%{$query}%")
                             ->orWhereHas('user', function($userQuery) use ($query) {
                                 $userQuery->where('name', 'LIKE', "%{$query}%")
                                           ->orWhere('store_name', 'LIKE', "%{$query}%");
                             });
                });
            })
            ->when($serviceType, function($q) use ($serviceType) {
                return $q->where('service_type', $serviceType);
            })
            ->when($city, function($q) use ($city) {
                return $q->where('city', $city);
            })
            ->when($sort == 'latest', function($q) {
                return $q->orderBy('created_at', 'desc');
            })
            ->when($sort == 'price_low', function($q) {
                return $q->orderBy('price', 'asc');
            })
            ->when($sort == 'price_high', function($q) {
                return $q->orderBy('price', 'desc');
            })
            ->paginate(12);
        
        $cities = ['دمشق', 'حلب', 'حمص', 'حماة', 'اللاذقية', 'طرطوس', 'دير الزور', 'السويداء', 'درعا', 'إدلب', 'الرقة', 'الحسكة', 'القامشلي'];
        
        return view('search.services', compact('services', 'query', 'serviceType', 'city', 'sort', 'cities'));
    }
}
