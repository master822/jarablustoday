<?php

namespace App\Http\Controllers;

use App\Models\ContentLike;
use App\Models\ContentComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentInteractionController extends Controller
{
    private function modelFromRequest(Request $request)
    {
        $request->validate([
            'type' => 'required|in:news,announcement,property',
            'id' => 'required|integer',
        ]);

        $map = [
            'news' => \App\Models\News::class,
            'announcement' => \App\Models\Announcement::class,
            'property' => \App\Models\Property::class,
        ];

        $model = $map[$request->type];

        return $model::approved()->findOrFail($request->id);
    }

    public function like(Request $request)
    {
        abort_unless(Auth::check(), 403);

        $model = $this->modelFromRequest($request);

        $like = ContentLike::where('user_id', Auth::id())
            ->where('likeable_id', $model->id)
            ->where('likeable_type', get_class($model))
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            ContentLike::create([
                'user_id' => Auth::id(),
                'likeable_id' => $model->id,
                'likeable_type' => get_class($model),
            ]);

            $liked = true;
        }

        return back()->with(
            'success',
            $liked ? 'تم تسجيل الإعجاب.' : 'تم إلغاء الإعجاب.'
        );
    }

    public function comment(Request $request)
    {
        abort_unless(Auth::check(), 403);

        $request->validate([
            'type' => 'required|in:news,announcement,property',
            'id' => 'required|integer',
            'content' => 'required|string|min:2|max:1000',
        ]);

        $model = $this->modelFromRequest($request);

        ContentComment::create([
            'user_id' => Auth::id(),
            'commentable_id' => $model->id,
            'commentable_type' => get_class($model),
            'comment' => $request->content,
            'status' => 'approved',
        ]);

        return back()->with(
            'success',
            'تم نشر تعليقك بنجاح.'
        );
    }
}
