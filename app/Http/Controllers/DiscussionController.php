<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Models\User;
use App\Notifications\NewDiscussionNotification;
use App\Notifications\NewDiscussionReplyNotification;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'lesson_id' => ['required', 'exists:lessons,id'],
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $discussion = Discussion::create([
            'course_id' => $validated['course_id'],
            'lesson_id' => $validated['lesson_id'],
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        $instructors = User::where('role', 'instructor')->get();

        foreach ($instructors as $instructor) {
            $instructor->notify(new NewDiscussionNotification($discussion));
        }

        return back();
    }

    public function reply(Request $request, Discussion $discussion)
    {
        $validated = $request->validate([
            'content' => ['required', 'string', 'max:2000'],
        ]);

        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'content' => $validated['content'],
        ]);

        $instructors = User::where('role', 'instructor')->get();

        foreach ($instructors as $instructor) {
            $instructor->notify(new NewDiscussionReplyNotification($reply));
        }

        return back();
    }
}
