<?php

namespace App\Filament\Pages;

use App\Models\Course;
use App\Models\DiscussionReply;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DiscussionsView extends Page
{
    protected static ?string $slug = 'discussions/{course}';

    protected string $view = 'filament.pages.discussions-view';

    protected static ?string $title = 'Thread Diskusi';

    public Course $course;

    public Collection $sidebarCourses;

    public function mount(Course $course): void
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $this->course = $course->load([
            'instructor',
            'modules.lessons' => fn ($q) => $q->orderBy('order'),
            'discussions' => fn ($q) => $q->orderByDesc('created_at'),
            'discussions.user',
            'discussions.lesson',
            'discussions.replies' => fn ($q) => $q->orderBy('created_at'),
            'discussions.replies.user',
            'discussions.replies.children',
            'discussions.replies.children.user',
        ]);

        $this->sidebarCourses = Course::query()
            ->withCount([
                'discussions',
                'discussions as unanswered_count' => fn ($q) => $q
                    ->whereDoesntHave('replies', fn ($r) => $r->whereRelation('user', 'role', 'instructor')),
            ])
            ->latest()
            ->get();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getViewData(): array
    {
        $replies = $this->course->discussions->flatMap->replies;

        return [
            'totalDiscussions' => $this->course->discussions->count(),
            'unansweredDiscussions' => $this->course->discussions
                ->filter(fn ($d) => $d->replies->isEmpty())
                ->count(),
        ];
    }

    public function deleteDiscussion(int $id): void
    {
        $discussion = $this->course->discussions()->findOrFail($id);
        $discussion->delete();

        Notification::make()
            ->title('Diskusi berhasil dihapus.')
            ->success()
            ->send();

        $this->reloadDiscussions();
    }

    public function deleteReply(int $replyId): void
    {
        $reply = DiscussionReply::findOrFail($replyId);
        $reply->delete();

        Notification::make()
            ->title('Balasan berhasil dihapus.')
            ->success()
            ->send();

        $this->reloadDiscussions();
    }

    private function reloadDiscussions(): void
    {
        $this->course->load([
            'discussions' => fn ($q) => $q->orderByDesc('created_at'),
            'discussions.user',
            'discussions.lesson',
            'discussions.replies' => fn ($q) => $q->orderBy('created_at'),
            'discussions.replies.user',
            'discussions.replies.children',
            'discussions.replies.children.user',
        ]);
    }
}
