<?php

namespace App\Filament\Resources\Students\Pages;

use App\Filament\Resources\Students\StudentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListStudents extends ListRecords
{
    protected static string $resource = StudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Export')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->exports([
                    ExcelExport::make('students')
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
                        ->withFilename('students-' . now()->format('Y-m-d')),
                ]),
            CreateAction::make()
                ->label('New Student'),
        ];
    }
}
