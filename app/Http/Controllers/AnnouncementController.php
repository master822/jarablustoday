<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::approved()
            ->with('user')
            ->withCount([
                'likes',
                'comments' => fn ($q) => $q->where('status', 'approved')
            ]);

        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        $announcements = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view(
            'announcements.index',
            compact('announcements')
        );
    }

    public function show($id)
    {
        $announcement = Announcement::approved()
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

        return view(
            'announcements.show',
            compact('announcement')
        );
    }

    public function create()
    {
        return view('announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:5',
            'phone' => 'nullable|string|max:30',
            'city' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:4096',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'phone' => $request->phone,
            'city' => $request->city,
            'status' => 'pending',
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request
                ->file('image')
                ->store('announcements', 'public');
        }

        $announcement = Announcement::create($data);

        $admins = User::where('user_type', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'sender_id' => Auth::id(),

                'notifiable_type' => 'announcement',
                'notifiable_id' => $announcement->id,

                'type' => 'content_pending',
                'title' => 'إعلان جديد بانتظار المراجعة',
                'message' =>
                    'المستخدم ' . Auth::user()->name .
                    ' أرسل إعلانًا جديدًا بعنوان: ' .
                    $announcement->title,
                'link' => route('admin.announcements'),
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('announcements.index')
            ->with(
                'success',
                'تم إرسال الإعلان إلى الإدارة للموافقة قبل نشره.'
            );
    }
}