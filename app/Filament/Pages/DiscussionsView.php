<?php

namespace App\Filament\Pages;

use App\Models\Course;
use App\Models\DiscussionReply;
use Filament\Actions\Action;
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

    public string $search = '';

    public function mount(Course $course): void
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $this->course = $course->load([
            'instructor',
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

    public function updatedSearch(): void
    {
        // triggers re-render
    }

    public function getViewData(): array
    {
        $discussions = $this->course->discussions;

        if ($this->search) {
            $discussions = $discussions->filter(function ($d) {
                $haystack = mb_strtolower($d->content . ' ' . $d->user->name . ' ' . ($d->lesson?->title ?? ''));
                return str_contains($haystack, mb_strtolower($this->search));
            });
        }

        return [
            'filteredDiscussions' => $discussions->values(),
            'totalDiscussions' => $this->course->discussions->count(),
            'unansweredDiscussions' => $this->course->discussions
                ->filter(fn ($d) => $d->replies->isEmpty())
                ->count(),
            'search' => $this->search,
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

    public function deleteDiscussionAction(): Action
    {
        return Action::make('deleteDiscussion')
            ->iconButton()
            ->icon('heroicon-o-trash')
            ->color('gray')
            ->tooltip('Hapus diskusi')
            ->requiresConfirmation()
            ->modalHeading('Hapus diskusi?')
            ->modalDescription('Semua balasan juga akan terhapus.')
            ->modalIcon('heroicon-o-trash')
            ->modalSubmitActionLabel('Hapus')
            ->color('danger')
            ->action(function (array $arguments): void {
                $this->deleteDiscussion($arguments['id']);
            });
    }

    public function deleteReplyAction(): Action
    {
        return Action::make('deleteReply')
            ->iconButton()
            ->icon('heroicon-o-trash')
            ->color('gray')
            ->tooltip('Hapus balasan')
            ->requiresConfirmation()
            ->modalHeading('Hapus balasan?')
            ->modalDescription('Tindakan tidak bisa dibatalkan.')
            ->modalIcon('heroicon-o-trash')
            ->modalSubmitActionLabel('Hapus')
            ->color('danger')
            ->action(function (array $arguments): void {
                $this->deleteReply($arguments['id']);
            });
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
