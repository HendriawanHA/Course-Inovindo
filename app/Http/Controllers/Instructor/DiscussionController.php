<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use App\Notifications\StudentDiscussionReplyNotification;
use Illuminate\Http\Request;
use Masmerise\Toaster\Toaster;

class DiscussionController extends Controller
{
    public function index()
    {
        $courses = $this->discussionCourses();

        if ($courses->isEmpty()) {
            $discussions = Discussion::whereRaw('1 = 0')->paginate(10);
            $totalDiscussions = 0;
            $unansweredDiscussions = 0;

            return view('instructor.discussions.index', compact('courses', 'discussions', 'totalDiscussions', 'unansweredDiscussions'));
        }

        return redirect()->route('instructor.courses.discussions', $courses->first());
    }

    public function byCourse(Request $request, Course $course)
    {
        abort_unless($course->user_id === auth()->id(), 403);

        $courses = $this->discussionCourses();
        $search = trim((string) $request->query('search', ''));

        $discussions = Discussion::query()
            ->where('course_id', $course->id)
            ->when($search !== '', fn($query) => $query->where(function ($query) use ($search) {
                $query->where('content', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('lesson', function ($query) use ($search) {
                        $query->where('title', 'like', "%{$search}%");
                    });
            }))
            ->with(['user', 'course', 'lesson', 'replies.user'])
            ->select('discussions.*')
            ->selectRaw('COALESCE((select MAX(dr.created_at) from discussion_replies dr where dr.discussion_id = discussions.id), discussions.created_at) as last_activity_at')
            ->orderByDesc('last_activity_at')
            ->latest('discussions.created_at')
            ->paginate(10)
            ->withQueryString();

        $totalDiscussions = Discussion::where('course_id', $course->id)->count();

        $unansweredDiscussions = Discussion::where('course_id', $course->id)
            ->whereDoesntHave('replies', fn($query) => $query->whereRelation('user', 'role', 'instructor'))
            ->count();

        return view('instructor.discussions.index', compact('courses', 'discussions', 'course', 'totalDiscussions', 'unansweredDiscussions', 'search'));
    }

    private function discussionCourses()
    {
        return Course::where('user_id', auth()->id())
            ->withCount(['discussions', 'enrollments'])
            ->withCount([
                'discussions as unanswered_discussions_count' => fn($query) => $query
                    ->whereDoesntHave('replies', fn($replyQuery) => $replyQuery->whereRelation('user', 'role', 'instructor')),
            ])
            ->withMax('discussions', 'created_at')
            ->withMax('discussionReplies', 'created_at')
            ->latest()
            ->get()
            ->map(function ($course) {
                $latestActivityAt = collect([
                    $course->discussions_max_created_at,
                    $course->discussion_replies_max_created_at,
                ])->filter()->max();

                $course->setAttribute('latest_activity_at', $latestActivityAt);

                return $course;
            })
            ->sortByDesc('latest_activity_at')
            ->values();
    }

    public function reply(Request $request, Discussion $discussion)
    {
        $request->validate([
            'content' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'integer', 'exists:discussion_replies,id'],
        ]);

        $isOwner = Course::where('id', $discussion->course_id)
            ->where('user_id', auth()->id())
            ->exists();

        abort_unless($isOwner, 403);

        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->integer('parent_id') ?: null,
            'content' => $request->content,
        ]);

        $discussion->user->notify(
            new StudentDiscussionReplyNotification($reply)
        );

        Toaster::success('Balasan berhasil dikirim.');

        return back();
    }

    public function replyFromComposer(Request $request)
    {
        $request->validate([
            'discussion_id' => ['required', 'integer', 'exists:discussions,id'],
            'content' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'integer', 'exists:discussion_replies,id'],
        ]);

        return $this->reply($request, Discussion::findOrFail($request->integer('discussion_id')));
    }
}
