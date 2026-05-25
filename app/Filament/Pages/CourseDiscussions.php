<?php

namespace App\Filament\Pages;

use App\Models\Course;
use App\Models\DiscussionReply;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use UnitEnum;

class CourseDiscussions extends Page
{
    protected string $view = 'filament.pages.course-discussions';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|UnitEnum|null $navigationGroup = 'Learning Management';

    protected static ?string $navigationLabel = 'Course Discussions';

    protected static ?string $title = 'Course Discussions';

    public ?int $replyingTo = null;

    public string $replyContent = '';

    public function getCoursesProperty()
    {
        return Course::query()
            ->where('user_id', auth()->id())
            ->with([
                'discussions' => fn ($query) => $query->latest(),
                'discussions.user',
                'discussions.lesson',
                'discussions.replies.user',
            ])
            ->latest()
            ->get();
    }

    public function setReplyingTo(int $discussionId): void
    {
        $this->replyingTo = $discussionId;
        $this->replyContent = '';
    }

    public function cancelReply(): void
    {
        $this->replyingTo = null;
        $this->replyContent = '';
    }

    public function sendReply(int $discussionId): void
    {
        $this->validate([
            'replyContent' => ['required', 'string', 'max:2000'],
        ]);

        DiscussionReply::create([
            'discussion_id' => $discussionId,
            'user_id' => auth()->id(),
            'content' => $this->replyContent,
        ]);

        $this->cancelReply();

        Notification::make()
            ->title('Balasan terkirim')
            ->success()
            ->send();
    }
}
