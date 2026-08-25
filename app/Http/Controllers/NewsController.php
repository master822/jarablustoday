<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::approved()
            ->with('user')
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(12);

        return view('news.index', compact('news'));
    }

    public function show($id)
    {
        $news = News::approved()
            ->with([
                'user',
                'comments' => fn ($q) => $q->where('status', 'approved')->with('user')
            ])
            ->withCount(['likes', 'comments'])
            ->findOrFail($id);

        return view('news.show', compact('news'));
    }

    public function create()
    {
        abort_unless(Auth::check(), 403);

        return view('news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'image' => 'nullable|image|max:4096',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'status' => 'pending',
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);

        $admins = User::where('user_type', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'sender_id' => Auth::id(),
                'type' => 'content_pending',
                'title' => 'خبر جديد بانتظار المراجعة',
                'message' => 'المستخدم ' . Auth::user()->name . ' أرسل خبرًا جديدًا بعنوان: ' . $data['title'],
                'link' => route('admin.news'),
                'is_read' => false,
            ]);
        }

        return redirect()
            ->route('news.index')
            ->with('success', 'تم إرسال الخبر إلى الإدارة للمراجعة والموافقة.');
    }
}
