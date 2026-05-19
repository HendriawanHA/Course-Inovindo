<?php

namespace App\Filament\Resources\Courses\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Auth;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /*
            |--------------------------------------------------------------------------
            | COURSE DETAILS
            |--------------------------------------------------------------------------
            */

            Section::make('Course Details')
                ->schema([

                    Grid::make(3)
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Judul Course')
                                        ->required()
                                        ->maxLength(255),

                                    Textarea::make('description')
                                        ->label('Deskripsi')
                                        ->rows(4)
                                        ->nullable(),

                                    TextInput::make('price')
                                        ->label('Harga')
                                        ->numeric()
                                        ->default(0)
                                        ->required(),

                                    Toggle::make('is_published')
                                        ->label('Publish')
                                        ->default(false),

                                    Select::make('user_id')
                                        ->hidden(fn() => Auth::user()?->role === 'instructor')
                                        ->label('Instructor')
                                        ->relationship(
                                            name: 'instructor',
                                            titleAttribute: 'name',
                                            modifyQueryUsing: fn($query) =>
                                            $query->where('role', 'instructor')
                                        )
                                        ->searchable()
                                        ->preload()
                                        ->nullable(),

                                ])
                                ->columnSpan(2),
                            Section::make()
                                ->schema([
                                    FileUpload::make('thumbnail')
                                        ->label('Thumbnail')
                                        ->image()
                                        ->disk('public')
                                        ->moveFiles()
                                        ->imagePreviewHeight('250')
                                        ->acceptedFileTypes([
                                            'image/jpeg',
                                            'image/png',
                                            'image/webp',
                                        ])
                                        ->maxSize(2048)
                                        ->imageEditor()
                                        ->nullable(),

                                ])
                        ]),


                ])
                ->columnSpanFull(),

            /*
            |--------------------------------------------------------------------------
            | CURRICULUM BUILDER
            |--------------------------------------------------------------------------
            */

            Section::make('Curriculum')
                ->description('Kelola module dan lesson course')
                ->schema([

                    Repeater::make('modules')
                        ->relationship()

                        // UI
                        ->collapsible()
                        ->collapsed()
                        ->cloneable()

                        // SORTING
                        ->reorderable()
                        ->orderColumn('order')

                        // BUTTON LABEL
                        ->addActionLabel('Tambah Module')

                        // LABEL MODULE
                        ->itemLabel(
                            fn(array $state): ?string =>
                            $state['title'] ?? 'New Module'
                        )

                        ->schema([

                            /*
                            |--------------------------------------------------------------------------
                            | MODULE
                            |--------------------------------------------------------------------------
                            */

                            Section::make()
                                ->schema([

                                    TextInput::make('title')
                                        ->label('Module Title')
                                        ->required()
                                        ->live(),

                                    Textarea::make('description')
                                        ->label('Module Description')
                                        ->rows(2)
                                        ->nullable(),

                                ])
                                ->columns(2),

                            /*
                            |--------------------------------------------------------------------------
                            | LESSONS
                            |--------------------------------------------------------------------------
                            */

                            Repeater::make('lessons')
                                ->relationship()

                                // UI
                                ->collapsible()
                                ->collapsed()
                                ->cloneable()

                                // SORT
                                ->reorderable()
                                ->orderColumn('order')

                                // BUTTON
                                ->addActionLabel('Tambah Lesson')

                                // LABEL LESSON
                                ->itemLabel(
                                    fn(array $state): ?string =>
                                    $state['title'] ?? 'New Lesson'
                                )

                                ->schema([

                                    TextInput::make('title')
                                        ->label('Lesson Title')
                                        ->required()
                                        ->live(),

                                    TextInput::make('video_url')
                                        ->label('YouTube URL')
                                        ->placeholder('https://youtube.com/...'),

                                    TextInput::make('duration')
                                        ->label('Duration')
                                        ->numeric()
                                        ->suffix('min'),

                                    Toggle::make('is_preview')
                                        ->label('Preview Lesson')
                                        ->default(false),

                                ])
                                ->columns(2)

                        ])
                        ->columnSpanFull()

                ])
                ->columnSpanFull(),

        ]);
    }
}
