<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
                          ->with('user')
                          ->latest()
                          ->paginate(12);
        return view('services.index', compact('services'));
    }

    public function show($id)
    {
        $service = Service::with('user')->findOrFail($id);
        return view('services.show', compact('service'));
    }

    public function byType($type)
    {
        $services = Service::where('service_type', $type)
                          ->where('is_active', true)
                          ->with('user')
                          ->paginate(12);
        return view('services.index', compact('services'));
    }
}
