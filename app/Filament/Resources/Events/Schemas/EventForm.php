<?php

namespace App\Filament\Resources\Events\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;

class EventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            TextInput::make('title')
                ->required(),

            TextInput::make('slug')
                ->required(),

            RichEditor::make('description')
                ->toolbarButtons([
                    'bold',
                    'italic',
                    'bulletList',
                    'orderedList',
                    'h2',
                    'h3',
                    'link',
                ])
                ->columnSpanFull()
                ->required(),

            FileUpload::make('thumbnail')
                ->image()
                ->disk('public')
                ->directory('events')
                ->openable()
                ->downloadable(),


            Select::make('event_type')
                ->options([
                    'Webinar' => 'Webinar',
                    'Workshop' => 'Workshop',
                    'Bootcamp' => 'Bootcamp',
                    'Seminar' => 'Seminar',
                    'Mentoring' => 'Mentoring',
                ])
                ->required(),

            Select::make('delivery_type')
                ->options([
                    'Online' => 'Live Stream',
                    'Offline' => 'Offline',
                    'Hybrid' => 'Hybrid',
                ])
                ->required(),

            TextInput::make('meeting_url'),

            Textarea::make('location'),

            TextInput::make('city'),

            TextInput::make('recording_url'),

            DateTimePicker::make('start_time')
                ->required(),

            DateTimePicker::make('end_time')
                ->required(),

            Select::make('instructor_id')
                ->relationship(
                    'instructor',
                    'name',
                    fn($query) => $query->where('role', 'instructor')
                )
                ->searchable()
                ->preload(),

            TextInput::make('capacity')
                ->numeric(),

            Toggle::make('is_paid'),

            TextInput::make('price')
                ->numeric(),

            Select::make('status')
                ->options([
                    'Draft' => 'Draft',
                    'Upcoming' => 'Upcoming',
                    'Live' => 'Live',
                    'Ended' => 'Ended',
                ])
                ->default('draft'),

            Toggle::make('is_active')
                ->default(true),

        ]);
    }
}
