<?php

namespace App\Filament\Resources\Instructors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class InstructorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),

                TextColumn::make('headline')
                    ->placeholder('-')
                    ->limit(40)
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exports([
                            ExcelExport::make('selected-instructors')
                                ->modifyQueryUsing(fn ($query) => $query->where('role', 'instructor'))
                                ->withColumns([
                                    Column::make('name')
                                        ->heading('Name'),
                                    Column::make('email')
                                        ->heading('Email address'),
                                    Column::make('headline')
                                        ->heading('Headline'),
                                    Column::make('created_at')
                                        ->heading('Joined')
                                        ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s')),
                                ])
                                ->withFilename('selected-instructors-' . now()->format('Y-m-d')),
                        ]),
                ]),
            ]);
    }
}
