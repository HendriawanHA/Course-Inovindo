<?php

namespace App\Filament\Resources\Events\Tables;

use Filament\Tables\Table;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class EventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                ImageColumn::make('thumbnail')
                    ->disk('public'),

                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('event_type'),

                TextColumn::make('delivery_type'),

                TextColumn::make('instructor.name')
                    ->label('Instructor'),

                TextColumn::make('start_time')
                    ->dateTime(),

                TextColumn::make('status')
                    ->label('Repeat')
                    ->formatStateUsing(fn (?string $state): string => ucfirst($state ?? 'once')),

                IconColumn::make('is_active')
                    ->boolean(),

            ]);
    }
}
