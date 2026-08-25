<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyController extends Controller
{
    public function sale(Request $request)
    {
        return $this->listing($request, 'sale');
    }

    public function rent(Request $request)
    {
        return $this->listing($request, 'rent');
    }

    private function listing(Request $request, string $type)
    {
        $query = Property::approved()
            ->where('type', $type)
            ->with('user')
            ->withCount([
                'likes',
                'comments' => fn ($q) => $q->where('status', 'approved')
            ]);

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('area', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $properties = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('properties.index', [
            'properties' => $properties,
            'type' => $type,
        ]);
    }

    public function show($id)
    {
        $property = Property::approved()
            ->with([
                'user',
                'comments' => fn ($q) =>
                    $q->where('status', 'approved')
                      ->with('user')
                      ->latest()
            ])
            ->withCount([
                'likes',
                'comments' => fn ($q) => $q->where('status', 'approved')
            ])
            ->findOrFail($id);

        return view('properties.show', compact('property'));
    }

    public function create()
    {
        return view('properties.create');
    }

public function store(Request $request)
{
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
        'images.*' => 'nullable|image|max:4096',
    ]);

    $images = [];

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $images[] = $image->store('properties', 'public');
        }
    }

    $property = Property::create([
        'user_id' => Auth::id(),
        'type' => $request->type,
        'title' => $request->title,
        'description' => $request->description,
        'price' => $request->price,
        'currency' => 'USD',
        'city' => $request->city,
        'area' => $request->area,
        'address' => $request->address,
        'rooms' => $request->rooms,
        'bathrooms' => $request->bathrooms,
        'area_m2' => $request->area_m2,
        'building_age' => $request->building_age,
        'finishing_type' => $request->finishing_type,
        'images' => $images,
        'status' => 'pending',
    ]);

    $admins = \App\Models\User::where('user_type', 'admin')->get();

    foreach ($admins as $admin) {
        \App\Models\Notification::create([
            'user_id' => $admin->id,
            'sender_id' => Auth::id(),
            'type' => 'content_pending',
            'title' => 'عقار جديد بانتظار المراجعة',
            'message' => 'المستخدم ' . Auth::user()->name .
                ' أرسل عقارًا جديدًا بعنوان: ' . $property->title,
            'link' => route('admin.properties'),
            'is_read' => false,
        ]);
    }

    return redirect()
        ->route(
            $request->type === 'sale'
                ? 'properties.sale'
                : 'properties.rent'
        )
        ->with(
            'success',
            'تم إرسال العقار إلى الإدارة للمراجعة والموافقة.'
        );
}
}
