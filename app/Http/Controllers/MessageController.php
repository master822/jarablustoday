<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Product;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function inbox()
    {
        $conversations = Message::where('sender_id', Auth::id())
                               ->orWhere('receiver_id', Auth::id())
                               ->with(['sender', 'receiver'])
                               ->get()
                               ->groupBy(function($message) {
                                   return $message->sender_id == Auth::id() 
                                       ? $message->receiver_id 
                                       : $message->sender_id;
                               })
                               ->map(function($messages) {
                                   return [
                                       'user' => $messages->first()->sender_id == Auth::id() 
                                           ? $messages->first()->receiver 
                                           : $messages->first()->sender,
                                       'last_message' => $messages->last(),
                                       'unread_count' => $messages->where('receiver_id', Auth::id())
                                                                   ->where('is_read', false)
                                                                   ->count()
                                   ];
                               })
                               ->sortByDesc(function($conversation) {
                                   return $conversation['last_message']->created_at;
                               });

        return view('messages.inbox', compact('conversations'));
    }

    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())
                          ->with('receiver')
                          ->orderBy('created_at', 'desc')
                          ->paginate(20);
        return view('messages.sent', compact('messages'));
    }

    public function showConversation($userId)
    {
        if ($userId == Auth::id()) {
            return redirect()->route('messages.inbox')->with('error', 'لا يمكنك فتح محادثة مع نفسك');
        }

        $otherUser = User::findOrFail($userId);
        $messages = Message::where(function($query) use ($userId) {
                            $query->where('sender_id', Auth::id())
                                  ->where('receiver_id', $userId);
                        })->orWhere(function($query) use ($userId) {
                            $query->where('sender_id', $userId)
                                  ->where('receiver_id', Auth::id());
                        })->orderBy('created_at', 'asc')
                        ->get();
        
        Message::where('sender_id', $userId)
               ->where('receiver_id', Auth::id())
               ->where('is_read', false)
               ->update(['is_read' => true]);
        
        return view('messages.conversation', compact('otherUser', 'messages'));
    }

    public function sendMessageInConversation(Request $request, $userId)
    {
        if ($userId == Auth::id()) {
            return back()->withErrors(['message' => 'لا يمكنك إرسال رسالة لنفسك']);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = trim($request->message);
        $message = ltrim($message, '.');
        $message = rtrim($message, '.');
        
        if (empty($message)) {
            return back()->withErrors(['message' => 'الرسالة لا يمكن أن تكون فارغة']);
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $userId,
            'content' => $message,
            'is_read' => false,
        ]);

        return redirect()->route('messages.conversation', $userId)
                        ->with('success', 'تم إرسال الرسالة بنجاح');
    }

    public function deleteMessage($id)
    {
        $message = Message::where('id', $id)
                         ->where(function($query) {
                             $query->where('sender_id', Auth::id())
                                   ->orWhere('receiver_id', Auth::id());
                         })->firstOrFail();
        $message->delete();
        return back()->with('success', 'تم حذف الرسالة بنجاح');
    }

    public function clearConversation($userId)
    {
        if ($userId == Auth::id()) {
            return redirect()->route('messages.inbox')->with('error', 'لا يمكنك مسح محادثة مع نفسك');
        }

        Message::where(function($query) use ($userId) {
                    $query->where('sender_id', Auth::id())
                          ->where('receiver_id', $userId);
                })->orWhere(function($query) use ($userId) {
                    $query->where('sender_id', $userId)
                          ->where('receiver_id', Auth::id());
                })->delete();
        
        return redirect()->route('messages.inbox')
                        ->with('success', 'تم مسح المحادثة بنجاح');
    }

    public function contactServiceProviderForm($userId)
    {
        if ($userId == Auth::id()) {
            return redirect()->route('services.index')->with('error', 'لا يمكنك التواصل مع نفسك');
        }

        $provider = User::findOrFail($userId);
        return view('messages.contact-provider', compact('provider'));
    }

    public function contactServiceProvider(Request $request, $userId)
    {
        if ($userId == Auth::id()) {
            return back()->withErrors(['message' => 'لا يمكنك إرسال رسالة لنفسك']);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = trim($request->message);
        $message = ltrim($message, '.');
        $message = rtrim($message, '.');
        
        if (empty($message)) {
            return back()->withErrors(['message' => 'الرسالة لا يمكن أن تكون فارغة']);
        }

        $provider = User::findOrFail($userId);
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $provider->id,
            'message' => $message,
            'is_read' => false,
        ]);

        return redirect()->route('messages.conversation', $provider->id)
                        ->with('success', 'تم إرسال رسالتك بنجاح');
    }

    public function contactMerchantForm($productId)
    {
        $product = Product::findOrFail($productId);
        $merchant = $product->user;

        if ($merchant->id == Auth::id()) {
            return redirect()->route('products.show', $productId)->with('error', 'هذا المنتج خاص بك، لا يمكنك التواصل مع نفسك');
        }

        return view('messages.contact-merchant', compact('product', 'merchant'));
    }

    public function contactMerchant(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if ($product->user_id == Auth::id()) {
            return back()->withErrors(['message' => 'هذا المنتج خاص بك، لا يمكنك إرسال رسالة لنفسك']);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = trim($request->message);
        $message = ltrim($message, '.');
        $message = rtrim($message, '.');
        
        if (empty($message)) {
            return back()->withErrors(['message' => 'الرسالة لا يمكن أن تكون فارغة']);
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $product->user_id,
            'message' => $message,
            'is_read' => false,
        ]);

        return redirect()->route('messages.conversation', $product->user_id)
                        ->with('success', 'تم إرسال رسالتك إلى التاجر بنجاح');
    }

    public function contactJobForm($jobId)
    {
        $job = Job::findOrFail($jobId);
        $publisher = $job->user;

        if ($publisher->id == Auth::id()) {
            return redirect()->route('jobs.show', $jobId)->with('error', 'هذه فرصة العمل خاصة بك، لا يمكنك التواصل مع نفسك');
        }

        return view('messages.contact-job', compact('job', 'publisher'));
    }

    public function contactJob(Request $request, $jobId)
    {
        $job = Job::findOrFail($jobId);

        if ($job->user_id == Auth::id()) {
            return back()->withErrors(['message' => 'هذه فرصة العمل خاصة بك، لا يمكنك إرسال رسالة لنفسك']);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = trim($request->message);
        $message = ltrim($message, '.');
        $message = rtrim($message, '.');
        
        if (empty($message)) {
            return back()->withErrors(['message' => 'الرسالة لا يمكن أن تكون فارغة']);
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $job->user_id,
            'message' => $message,
            'is_read' => false,
        ]);

        return redirect()->route('messages.conversation', $job->user_id)
                        ->with('success', 'تم إرسال رسالتك بنجاح');
    }
}
