<?php

namespace App\Filament\Resources\Discussions;

use App\Filament\Resources\Discussions\Pages\ListDiscussions;
use App\Filament\Resources\Discussions\Pages\ViewDiscussion;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;
use Illuminate\Database\Eloquent\Builder;

class DiscussionResource extends Resource
{
    protected static ?string $model = Discussion::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static string|UnitEnum|null $navigationGroup = 'Learning Management';

    protected static ?string $navigationLabel = 'Discussions';

    protected static ?string $modelLabel = 'Discussion';

    protected static ?string $pluralModelLabel = 'Discussions';
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->with(['user', 'course', 'lesson', 'replies']);

        if (auth()->user()?->role === 'instructor') {
            $query->whereHas('course', function (Builder $query) {
                $query->where('user_id', auth()->id());
            });
        }

        return $query;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('content')
                    ->label('Discussion')
                    ->disabled()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('lesson.title')
                    ->label('Lesson')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('content')
                    ->label('Discussion')
                    ->limit(60)
                    ->wrap()
                    ->searchable(),

                TextColumn::make('replies_count')
                    ->counts('replies')
                    ->label('Replies'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('reply')
                    ->label('Balas')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('primary')
                    ->modalHeading(fn(Discussion $record) => 'Balas diskusi dari ' . $record->user->name)
                    ->modalDescription(fn(Discussion $record) => $record->content)
                    ->schema([
                        Textarea::make('content')
                            ->label('Balasan instruktur')
                            ->placeholder('Tulis balasan untuk student...')
                            ->required()
                            ->maxLength(2000)
                            ->rows(4),
                    ])
                    ->action(function (Discussion $record, array $data): void {
                        DiscussionReply::create([
                            'discussion_id' => $record->id,
                            'user_id' => auth()->id(),
                            'content' => $data['content'],
                        ]);

                        Notification::make()
                            ->title('Balasan terkirim')
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDiscussions::route('/'),
        ];
    }
}
