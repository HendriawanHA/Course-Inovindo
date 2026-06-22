<?php

namespace App\Filament\Pages;

use App\Models\Course;
use App\Models\Discussion;
use BackedEnum;
use UnitEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class Discussions extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|UnitEnum|null $navigationGroup = 'Moderation';

    protected static ?string $navigationLabel = 'Discussions';

    protected static ?string $title = 'Diskusi';

    protected string $view = 'filament.pages.discussions';

    public static function canViewAny(): bool
    {
        return Auth::user()?->role === 'admin';
    }

    public function getViewData(): array
    {
        $courses = Course::query()
            ->withCount([
                'discussions',
                'discussions as unanswered_count' => fn ($q) => $q
                    ->whereDoesntHave('replies', fn ($r) => $r->whereRelation('user', 'role', 'instructor')),
            ])
            ->with(['instructor'])
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

        return [
            'courses' => $courses,
            'totalDiscussions' => Discussion::count(),
        ];
    }
}
