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
        $services = Service::where('user_id', $user->id)->get();
        return view('service-provider.dashboard', compact('user', 'services'));
    }

    public function services()
    {
        $services = Service::where('user_id', Auth::id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        return view('service-provider.services', compact('services'));
    }

    public function createServiceForm()
    {
        return view('service-provider.create-service');
    }

    public function createService(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string',
            'price' => 'nullable|numeric',
            'price_type' => 'nullable|string'
        ]);

        Service::create([
            'user_id' => Auth::id(),
            'service_name' => $request->service_name,
            'description' => $request->description,
            'city' => $request->city,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'is_active' => true
        ]);

        return redirect()->route('service-provider.services')
                        ->with('success', 'تم إضافة الخدمة بنجاح');
    }

    public function editService($id)
    {
        $service = Service::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('service-provider.edit-service', compact('service'));
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string',
            'price' => 'nullable|numeric',
            'price_type' => 'nullable|string'
        ]);

        $service->update([
            'service_name' => $request->service_name,
            'description' => $request->description,
            'city' => $request->city,
            'price' => $request->price,
            'price_type' => $request->price_type,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('service-provider.services')
                        ->with('success', 'تم تحديث الخدمة بنجاح');
    }

    public function deleteService($id)
    {
        $service = Service::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $service->delete();
        return redirect()->route('service-provider.services')
                        ->with('success', 'تم حذف الخدمة بنجاح');
    }

    // ===== دوال فرص العمل =====
    public function jobs()
    {
        $jobs = Job::where('user_id', Auth::id())
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);
        return view('service-provider.jobs', compact('jobs'));
    }

    public function createJobForm()
    {
        return view('service-provider.create-job');
    }

    public function createJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'nullable|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'salary_type' => 'nullable|string'
        ]);

        Job::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'salary_type' => $request->salary_type ?? 'monthly',
            'is_active' => true
        ]);

        return redirect()->route('service-provider.jobs')
                        ->with('success', 'تم إضافة فرصة العمل بنجاح');
    }

    public function editJob($id)
    {
        $job = Job::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('service-provider.edit-job', compact('job'));
    }

    public function updateJob(Request $request, $id)
    {
        $job = Job::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'location' => 'nullable|string',
            'salary_min' => 'nullable|numeric',
            'salary_max' => 'nullable|numeric',
            'salary_type' => 'nullable|string'
        ]);

        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'salary_min' => $request->salary_min,
            'salary_max' => $request->salary_max,
            'salary_type' => $request->salary_type ?? 'monthly',
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('service-provider.jobs')
                        ->with('success', 'تم تحديث فرصة العمل بنجاح');
    }

    public function deleteJob($id)
    {
        $job = Job::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $job->delete();
        return redirect()->route('service-provider.jobs')
                        ->with('success', 'تم حذف فرصة العمل بنجاح');
    }
}
