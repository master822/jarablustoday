<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Service;
use App\Models\Discount;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // تصدير المنتجات
    public function exportProducts()
    {
        $products = Product::where('status', 'active')->get();
        
        $filename = 'products_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // العناوين
            fputcsv($file, ['ID', 'الاسم', 'الوصف', 'السعر', 'الحالة', 'البائع', 'التاريخ']);
            
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->description,
                    $product->price,
                    $product->condition,
                    $product->user->name ?? 'غير معروف',
                    $product->created_at->format('Y-m-d'),
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    // تصدير الخدمات
    public function exportServices()
    {
        $services = Service::where('is_active', 1)->get();
        
        $filename = 'services_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($services) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'اسم الخدمة', 'الوصف', 'نوع الخدمة', 'المدينة', 'مقدم الخدمة', 'التاريخ']);
            
            foreach ($services as $service) {
                fputcsv($file, [
                    $service->id,
                    $service->service_name,
                    $service->description,
                    $service->service_type,
                    $service->city,
                    $service->user->name ?? 'غير معروف',
                    $service->created_at->format('Y-m-d'),
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    // تصدير المستخدمين
    public function exportUsers()
    {
        $users = User::all();
        
        $filename = 'users_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'الاسم', 'البريد الإلكتروني', 'النوع', 'المدينة', 'رقم الهاتف', 'الحالة', 'التاريخ']);
            
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->user_type,
                    $user->city,
                    $user->phone,
                    $user->is_active ? 'نشط' : 'غير نشط',
                    $user->created_at->format('Y-m-d'),
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }

    // تصدير التخفيضات
    public function exportDiscounts()
    {
        $discounts = Discount::with(['product', 'merchant'])->get();
        
        $filename = 'discounts_' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($discounts) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'الاسم', 'الوصف', 'نسبة التخفيض', 'المنتج', 'التاجر', 'الحالة', 'التاريخ']);
            
            foreach ($discounts as $discount) {
                fputcsv($file, [
                    $discount->id,
                    $discount->name,
                    $discount->description,
                    $discount->percentage . '%',
                    $discount->product->name ?? 'غير معروف',
                    $discount->merchant->name ?? 'غير معروف',
                    $discount->is_active ? 'نشط' : 'غير نشط',
                    $discount->created_at->format('Y-m-d'),
                ]);
            }
            
            fclose($file);
        };
        
        return Response::stream($callback, 200, $headers);
    }
}
