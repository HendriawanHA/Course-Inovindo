<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::where('user_id', auth()->id())
            ->withCount('discussions')
            ->get();

        $courseIds = $courses->pluck('id');

        $discussions = Discussion::query()
            ->whereIn('course_id', $courseIds)
            ->with(['user', 'course', 'lesson', 'replies.user'])
            ->when($request->course_id, function ($query) use ($request) {
                $query->where('course_id', $request->course_id);
            })
            ->latest()
            ->get();

        return view('instructor.discussions.index', compact('courses', 'discussions'));
    }

    public function reply(Request $request, Discussion $discussion)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $isOwner = Course::where('id', $discussion->course_id)
            ->where('user_id', auth()->id())
            ->exists();

        abort_unless($isOwner, 403);

        DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }
}
