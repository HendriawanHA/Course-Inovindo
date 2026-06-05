<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\ExportBulkAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class StudentsTable
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
                TextColumn::make('points')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('level')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Joined'),

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
                            ExcelExport::make('selected-students')
                                ->modifyQueryUsing(fn ($query) => $query->where('role', 'student'))
                                ->withColumns([
                                    Column::make('name')
                                        ->heading('Name'),
                                    Column::make('email')
                                        ->heading('Email address'),
                                    Column::make('points')
                                        ->heading('Points'),
                                    Column::make('level')
                                        ->heading('Level'),
                                    Column::make('created_at')
                                        ->heading('Joined')
                                        ->formatStateUsing(fn ($state) => $state?->format('Y-m-d H:i:s')),
                                ])
                                ->withFilename('selected-students-' . now()->format('Y-m-d')),
                        ]),
                ])->label('Actions'),
            ]);
    }
}
