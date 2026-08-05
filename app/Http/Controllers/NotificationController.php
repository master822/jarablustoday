<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
                                    ->with('sender')
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(20);
        
        $unreadCount = Notification::where('user_id', Auth::id())
                                   ->where('is_read', false)
                                   ->count();
        
        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
                                   ->where('user_id', Auth::id())
                                   ->firstOrFail();
        
        $notification->is_read = true;
        $notification->save();
        
        return back()->with('success', 'تم تحديد الإشعار كمقروء');
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
                   ->where('is_read', false)
                   ->update(['is_read' => true]);
        
        return back()->with('success', 'تم تحديد جميع الإشعارات كمقروءة');
    }

    public function delete($id)
    {
        $notification = Notification::where('id', $id)
                                   ->where('user_id', Auth::id())
                                   ->firstOrFail();
        
        $notification->delete();
        
        return back()->with('success', 'تم حذف الإشعار');
    }

    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        
        return back()->with('success', 'تم حذف جميع الإشعارات');
    }

    public function getUnreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
                            ->where('is_read', false)
                            ->count();
        
        return response()->json(['count' => $count]);
    }

    public function getLatest()
    {
        $notifications = Notification::where('user_id', Auth::id())
                                    ->where('is_read', false)
                                    ->with('sender')
                                    ->orderBy('created_at', 'desc')
                                    ->limit(5)
                                    ->get();
        
        return response()->json(['notifications' => $notifications]);
    }
}
