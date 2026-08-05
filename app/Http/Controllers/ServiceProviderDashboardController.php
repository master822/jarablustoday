<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceProviderDashboardController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $services = Service::where('user_id', $user->id)->count();
        $jobs = Job::where('user_id', $user->id)->count();
        
        // رابط المتجر
        $storeUrl = url('/merchants/' . $user->id);
        
        return view('service-provider.dashboard', compact('user', 'services', 'jobs', 'storeUrl'));
    }

    public function services()
    {
        $services = Service::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        return view('service-provider.services', compact('services'));
    }

    // دوال أخرى...
}
